<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
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

    protected function configure() {
        $this->setName('owt:clearTestData');
    }

    protected function executeCommand(InputInterface $inputInterface, OutputInterface $outputInterface) {
        $testUsers = $this->userService->getTestUsers();
        foreach ($testUsers as $testUser) {
            $this->overwatchService->deleteByUser($testUser);
            $this->userService->deleteUser($testUser);
        }
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
    }
}