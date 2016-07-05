<?php

namespace AppBundle\Command;

use FeedbackBundle\Service\FeedbackService;
use OverwatchBundle\Service\OverwatchService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Service\UserService;

class DeleteTestDataCommand extends BaseContainerAwareCommand {

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    /**
     * @var FeedbackService
     */
    private $feedbackService;

    protected function configure() {
        $this->setName('owt:clearTestData');
    }

    protected function initServices() {
        $this->userService = $this->getService(UserService::ID);
        $this->overwatchService = $this->getService(OverwatchService::ID);
        $this->feedbackService = $this->getService(FeedbackService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $testUsers = $this->userService->getTestUsers();
        foreach ($testUsers as $testUser) {
            $this->overwatchService->deleteByUser($testUser);
            $this->feedbackService->deleteByUser($testUser);

            $this->userService->deleteUser($testUser);
            /*
             * TODO: delete demoFiles & demos
             */
        }
    }
}