<?php

namespace DemoBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use AppBundle\Util\AppSerializer;
use AppBundle\Util\RandomUtil;
use DemoBundle\Document\DemoFile;
use DemoBundle\Service\DemoService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Service\UserService;

class DummyDemoInfoQueueCommand extends BaseContainerAwareCommand {

    const OPT_USER_NAME = 'user';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var bool
     */
    private $verbose;

    protected function configure() {
        $this->setName('owt:queueDummyDemo')
            ->addOption(
                self::OPT_USER_NAME,
                'u',
                InputArgument::OPTIONAL,
                'username or id'
            );
    }

    protected function initServices() {
        $this->userService = $this->getService(UserService::ID);
        $this->demoService = $this->getService(DemoService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $serializer = AppSerializer::getInstance();
        $this->verbose = $input->getOption('verbose');
        $inputUser = $input->getOption(self::OPT_USER_NAME);

        if (!$inputUser) {
            $this->error('user required');
            die(1);
        }

        $user = $this->userService->findById($inputUser);
        if (!$user) {
            $user = $this->userService->findByUsernameOrEmail($inputUser);
        }

        if (!$user) {
            $this->error('user not found');
            die(1);
        }

        // create demo file for integrity
        $demoFile = new DemoFile('someFile', $user->getId());
        $this->demoService->saveDemoFile($demoFile);

        if ($this->verbose) {
            $this->info('created dummy demo file: ' . $serializer->toJson($demoFile));
        }

        $demoInfo = RandomUtil::getRandomDemo($user);
        /* @var \OldSound\RabbitMqBundle\RabbitMq\Producer $producer */
        $producer = $this->getService('old_sound_rabbit_mq.demo_info_upload_producer');
        $producer->setContentType('application/json');

        $message = $serializer->toJson($demoInfo);
        $producer->publish($message);

        if ($this->verbose) {
            $debugTmp = $demoInfo;
            $debugTmp->getMatchInfo()->getTeam1()->setPlayers([]);
            $debugTmp->getMatchInfo()->getTeam2()->setPlayers([]);
            $round1 = $debugTmp->getRounds()[0];
            $debugTmp->setRounds([$round1]);

            $this->info('published demo info to queue: ' . $serializer->toJson($debugTmp));
        }
    }
}