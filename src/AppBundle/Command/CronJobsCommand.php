<?php

namespace AppBundle\Command;

use AppBundle\Service\CronJobService;
use AppBundle\Util\StopWatch;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class CronJobsCommand extends BaseContainerAwareCommand {

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var CronJobService
     */
    private $cronService;

    protected function configure() {
        $this->setName('owt:cron')
            ->setHelp('Run automated tasks');
    }

    protected function initServices() {
        $this->kernel = $this->container->get('kernel');
        $this->cronService = $this->container->get(CronJobService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $runningTasks = $this->cronService->getRunningJobs();

        if ($runningTasks) {
            $this->info('currently running tasks:');
            foreach ($runningTasks as $runningTask) {
                $this->info('- ' . $runningTask->getName());
            }
        } else {
            $this->info('no running tasks');
        }

        $dueTasks = $this->cronService->getDueJobs();

        foreach ($dueTasks as $cronJob) {
            $this->info(sprintf('starting task %s:', $cronJob->getName()));

            $application = new Application($this->kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput(['command' => $cronJob->getCommand()]);
            $output = new BufferedOutput();

            $application->run($input, $output);
            $this->output->write($output->fetch());

            $this->info();
            $this->info('task finished');
        }
    }
}