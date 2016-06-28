<?php

namespace AppBundle\Repository;

use AppBundle\Document\CronJob;
use AppBundle\Exception\ServerErrorException;

class CronJobRepository extends BaseRepository {

    const ID = 'AppBundle:CronJob';

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentRepository
     */
    private function getRepository() {
        return $this->dm->getRepository(self::ID);
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    private function getQueryBuilder() {
        return $this->dm->createQueryBuilder(self::ID);
    }

    /**
     * @return CronJob[]
     */
    public function getAll() {
        return $this->getRepository()->findAll();
    }

    /**
     * @param string $jobName
     * @return CronJob ]null
     */
    public function findOneByName($jobName) {
        return $this->getRepository()->findOneBy(['name' => $jobName]);
    }

    /**
     * @return CronJob[]
     */
    public function getNotRunningCronJobs() {
        return $this->getQueryBuilder()
            ->field('running')->equals(false)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * @return CronJob[]
     */
    public function getRunningJobs() {
        return $this->getQueryBuilder()
            ->field('running')->equals(true)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * @param CronJob $cronJob
     * @return CronJob
     * @throws ServerErrorException
     */
    public function save(CronJob $cronJob) {
        if ($this->findOneByName($cronJob->getName())) {
            throw new ServerErrorException(sprintf('cronjob %s is configured twice', $cronJob->getName()));
        }

        return $this->update($cronJob);
    }

    /**
     * @param CronJob $cronJob
     * @return CronJob
     */
    public function update(CronJob $cronJob) {
        $this->dm->persist($cronJob);
        $this->dm->flush();
        return $cronJob;
    }

    public function dropAll() {
        $this->getQueryBuilder()
            ->remove()
            ->getQuery()
            ->execute();
    }
}