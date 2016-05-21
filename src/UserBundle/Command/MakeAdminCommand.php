<?php

namespace UserBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Service\UserService;

class MakeAdminCommand extends BaseContainerAwareCommand {

    /**
     * @var UserService
     */
    private $userService;

    protected function configure() {
        $this->setName('user:makeAdmin')
            ->addArgument(
                'user',
                InputArgument::REQUIRED,
                'username of user to give admin privileges'
            );
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $username = $input->getArgument('user');
        $dbUser = $this->userService->findByUsernameOrEmail($username);

        if (!$dbUser) {
            $this->output->writeln('[ERR] user not found');
            return;
        }

        $dbUser->setIsadmin(true);
        $this->userService->update($dbUser);

        $output->writeln(sprintf('[END] %s now has admin privileges', $dbUser->getId()));
    }
}