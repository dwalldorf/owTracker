<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseContainerAwareCommand extends ContainerAwareCommand {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected final function execute(InputInterface $input, OutputInterface $output) {
        $this->container = $this->getContainer();
        $this->output = $output;

        $this->executeCommand($input, $output);
    }

    /**
     * @param string $msg
     */
    protected function info($msg = '') {
        $this->output->writeln('[INFO] ' . $msg);
    }

    /**
     * @param string $msg
     */
    protected function error($msg) {
        $this->output->writeln('[ERROR] ' . $msg);
    }

    protected abstract function executeCommand(InputInterface $inputInterface, OutputInterface $outputInterface);
}