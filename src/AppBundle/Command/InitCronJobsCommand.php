<?php

namespace AppBundle\Command;

use AppBundle\Service\CronJobService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCronJobsCommand extends BaseContainerAwareCommand {

    /**
     * @var CronJobService
     */
    private $cronJobService;

    protected function configure() {
        $this->setName('owt:initCron')
            ->setHelp('Initialize automated tasks');
    }

    protected function initServices() {
        $this->cronJobService = $this->container->get(CronJobService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $createdJobs = $this->cronJobService->initialize();

        if ($createdJobs) {
            $this->info(sprintf('created %d jobs:', count($createdJobs)));

            foreach ($createdJobs as $job) {
                $this->info(sprintf('- %s - %s', $job->getName(), $job->getCommand()));
            }
        }
    }
}