<?php

namespace AppBundle\Service;

use AppBundle\Document\CronJob;
use AppBundle\Repository\CronJobRepository;

class CronJobService extends BaseService {

    const ID = 'app.cron_job_service';

    /**
     * @var CronJobRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(CronJobRepository::ID);
    }

    /**
     * @return CronJob[]
     */
    public function initialize() {
        $this->repository->dropAll();
        $jobsToCreate = $this->container->getParameter('cronjobs');

        foreach ($jobsToCreate as $name => $jobToCreate) {
            $job = new CronJob(null, $name, $jobToCreate['command'], $jobToCreate['interval']);
            $this->repository->save($job);
        }

        return $this->repository->getAll();
    }

    /**
     * @return CronJob[]
     */
    public function getDueJobs() {
        $dueJobs = [];
        $jobs = $this->repository->getNotRunningCronJobs();

        if (!$jobs) {
            return $dueJobs;
        }

        foreach ($jobs as $job) {
            $diffToLastRunInMinutes = ($job->getLastRun() - time()) / 60;

            if ($job->getLastRun() == 0 || $diffToLastRunInMinutes > $job->getInterval()) {
                $dueJobs[] = $job;
            }
        }

        return $dueJobs;
    }

    /**
     * @return CronJob[]
     */
    public function getRunningJobs() {
        return $this->repository->getRunningJobs();
    }

    /**
     * @param CronJob $job
     * @return CronJob
     */
    public function setJobRunning(CronJob $job) {
        $job->setRunning();
        $this->repository->update($job);

        return $job;
    }

    /**
     * @param CronJob $job
     * @return CronJob
     */
    public function setJobDone(CronJob $job) {
        $job->setRunning(false);
        $this->repository->update($job);

        return $job;
    }
}