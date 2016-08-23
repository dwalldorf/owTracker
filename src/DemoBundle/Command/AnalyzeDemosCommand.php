<?php

namespace DemoBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
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
     * @var UserService
     */
    private $userService;

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
        $this->userService = $this->getService(UserService::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $this->limit = $input->getArgument(self::ARG_LIMIT_NAME);
        $demos = $this->demoService->getDemosToAnalyze($this->limit);

        foreach ($demos as $demo) {
            $owningUser = $this->userService->findById($demo->getUserId());
            $playersToTrack = $owningUser->getUserSettings()->getFollowSteamIds();
            $trackedPlayers = [];

            // find players to track
            foreach ($demo->getMatchInfo()->getPlayers() as $player) {
                if (in_array($player->getSteamId64(), $playersToTrack)) {
                    $trackedPlayers[] = $player;
                }
            }

            ddd($trackedPlayers);

            foreach ($demo->getRounds() as $round) {
                foreach ($round->getEvents() as $event) {
                }
            }

            $this->analyzedDemos++;
        }

        $this->info(sprintf('Analyzed %d demos', $this->analyzedDemos));
    }
}