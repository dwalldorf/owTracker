<?php

namespace DemoBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReadDemoInfoCommand extends BaseContainerAwareCommand {

    const OPT_LIMIT_NAME = 'limit';

    protected function configure() {
        $this->setName('owt:readDemoInfo')
            ->setHelp('Read parsed demo info from queue')
            ->addOption(
                self::OPT_LIMIT_NAME,
                'l',
                InputArgument::REQUIRED,
                'limit of parsed demo info to fetch'
            );
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $limit = $input->getOption(self::OPT_LIMIT_NAME);
    }

    protected function initServices() {
    }
}