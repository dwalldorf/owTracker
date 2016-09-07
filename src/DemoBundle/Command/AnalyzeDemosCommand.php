<?php

namespace DemoBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use DemoBundle\Service\DemoAnalyzerService;
use DemoBundle\Service\DemoService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Service\UserService;

class AnalyzeDemosCommand extends BaseContainerAwareCommand {

    const ARG_LIMIT_NAME = 'limit';

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var DemoAnalyzerService
     */
    private $demoAnalyzerService;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $analyzedDemos = 0;

    protected function configure() {
        $this->setName('owt:analyzeDemos')
            ->addArgument(self::ARG_LIMIT_NAME, InputArgument::REQUIRED, 'number of demos to analyze');
    }

    protected function initServices() {
        $this->demoService = $this->getService(DemoService::ID);
        $this->demoAnalyzerService = $this->getService(DemoAnalyzerService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $this->limit = $input->getArgument(self::ARG_LIMIT_NAME);
        $demos = $this->demoService->getDemosToAnalyze($this->limit);

        /*
         * TODO: just do this when reading demos from queue but keep anyway for re-analyzing demos (when steamid's are added for example)
         */
        $this->demoAnalyzerService->analyzeDemos($demos);

        $this->info(sprintf('Analyzed %d demos', $this->analyzedDemos));
    }
}