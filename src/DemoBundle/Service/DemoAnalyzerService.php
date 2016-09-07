<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use DemoBundle\Document\Demo;
use DemoBundle\Document\DemoStats;
use DemoBundle\Model\DemoEvent;
use UserBundle\Service\UserService;

class DemoAnalyzerService extends BaseService {

    const ID = 'demo.demo_analyzer_service';

    const ENAME_EVENT_ID = 'eventId';

    const ENAME_NAME = 'name';

    const ENAME_TIME_IN_ROUND = 'timeInRound';

    const ENAME_DATA = 'data';

    const ENAME_USER_ID = 'userid';

    const ENAME_ASSISTER = 'assister';

    const ENAME_ATTACKER = 'attacker';

    private $ignoredEvents = [
        'weapon_fire',
        'decoy_started',
        'decoy_detonate',
        'smokegrenade_detonate',
        'smokegrenade_expired',
        'flashbang_detonate',
    ];

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var DemoStatsService
     */
    private $demoStatsService;

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
        $this->demoStatsService = $this->getService(DemoStatsService::ID);
        $this->userService = $this->getService(UserService::ID);
    }

    /**
     * @param Demo[] $demos
     * @return string[] created ids
     */
    public function analyzeDemos($demos) {
        $analyzedDemos = [];

        /*
         * TODO: for re-analyzing demos: get all stats that are already processed and exclude from being processed again
         */
        foreach ($demos as $demo) {
            $trackedPlayers = $this->getPlayersToTrack($demo);

            if (!$trackedPlayers || !count($trackedPlayers) > 0) {
                continue;
            }

            $demoStats = $this->analyzeEvents($demo, $trackedPlayers);
            ddd($demoStats);
//            $demoStats = $this->demoStatsService->save($demoStats);

//            $analyzedDemos[] = $demoStats->getId();
        }
        return $analyzedDemos;
    }

    /**
     * @param Demo $demo
     * @return int[]
     */
    private function getPlayersToTrack(Demo $demo) {
        $owningUser = $this->userService->findById($demo->getUserId());

        // find players to track
        $playersToTrack = [];
        foreach ($demo->getMatchInfo()->getPlayers() as $player) {
            if (in_array($player->getSteamId64(), $owningUser->getUserSettings()->getFollowSteamIdsFlatArray())) {
                $playersToTrack[] = $player->getUserId();
            }
        }

        return $playersToTrack;
    }

    /**
     * @param Demo $demo
     * @param array $trackedPlayers
     * @return \DemoBundle\Document\DemoStats[]
     */
    private function analyzeEvents(Demo $demo, array $trackedPlayers) {
        /* @var $eventsToAnalyze DemoEvent[] */
        $eventsToAnalyze = [];
        ddd($demo);
        
        foreach ($demo->getRounds() as $round) {
            $eventsArray = $round->getEvents();
            foreach ($eventsArray as $key => $eventArray) {
                if (!array_key_exists(self::ENAME_EVENT_ID, $eventArray) ||
                    !array_key_exists(self::ENAME_NAME, $eventArray) ||
                    !array_key_exists(self::ENAME_TIME_IN_ROUND, $eventArray)
                ) {
                    continue;
                }
                if (in_array($eventArray[self::ENAME_NAME], $this->ignoredEvents)) {
                    continue;
                }

                $event = new DemoEvent();
                $event->setEventId($eventArray[self::ENAME_EVENT_ID])
                    ->setName($eventArray[self::ENAME_NAME])
                    ->setTimeInRound($eventArray[self::ENAME_TIME_IN_ROUND]);

                if (array_key_exists(self::ENAME_DATA, $eventArray)) {
                    $event->setData($eventArray[self::ENAME_DATA]);
                }

                $eventsToAnalyze[] = $event;
                unset($eventsArray[$key]);
            }
        }
        ddd($eventsToAnalyze);

        $allStats = [];
        foreach ($eventsToAnalyze as $event) {
            switch ($event->getName()) {
                case 'player_death':
                    $allStats = $this->analyzeDeath($event, $allStats, $trackedPlayers, $demo);
                    break;
                case 'bomb_defused':
                    $allStats = $this->analyzeBombDefused($event, $allStats, $trackedPlayers, $demo);
                    break;
                case 'bomb_planted':
                    $allStats = $this->analyzeBombPlanted($event, $allStats, $trackedPlayers, $demo);
                    break;
                case 'round_mvp':
                    $allStats = $this->analyzeMvp($event, $allStats, $trackedPlayers, $demo);
                    break;
                default:
                    break;
            }
        }

        foreach ($allStats as $key => $stats) {
            if ($stats->getKills() > 0) {
                $allStats[$key]->setHeadshotPercentage(($stats->getHeadshots() / $stats->getKills()) * 100);

                if ($stats->getDeaths() == 0) {
                    $allStats[$key]->setKdr($stats->getKills());
                } else {
                    $allStats[$key]->setKdr($stats->getKills() / $stats->getDeaths());
                }
            }
        }

        return $allStats;
    }

    /**
     * @param DemoEvent $event
     * @param DemoStats[] $allStats
     * @param array $trackedPlayers
     * @param Demo $demo
     * @return DemoStats
     */
    private function analyzeDeath(DemoEvent $event, array $allStats, array $trackedPlayers, Demo $demo) {
        $data = $event->getData();
        if (in_array($data[self::ENAME_USER_ID], $trackedPlayers)) {
            $userId = $data[self::ENAME_USER_ID];

            $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
            $playerStats->addDeath();
            $allStats = $this->setPlayerStats($allStats, $userId, $playerStats);
        }

        if (in_array($data[self::ENAME_ASSISTER], $trackedPlayers)) {
            $userId = $data[self::ENAME_ASSISTER];

            $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
            $playerStats->addAssist();
            $allStats = $this->setPlayerStats($allStats, $userId, $playerStats);
        }

        if (in_array($data[self::ENAME_ATTACKER], $trackedPlayers)) {
            $userId = $data[self::ENAME_ATTACKER];

            $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
            $playerStats->addKill();
            if ($data['headshot'] == true) {
                $playerStats->addHeadshot();
            }

            $allStats = $this->setPlayerStats($allStats, $userId, $playerStats);
        }
        return $allStats;
    }

    /**
     * @param DemoEvent $event
     * @param array $allStats
     * @param array $trackedPlayers
     * @param Demo $demo
     * @return array
     */
    private function analyzeBombPlanted(DemoEvent $event, array $allStats, array $trackedPlayers, Demo $demo) {
        $data = $event->getData();
        $userId = $data[self::ENAME_USER_ID];

        $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
        $playerStats->addBombPlant();
        $this->setPlayerStats($allStats, $userId, $playerStats);

        return $allStats;
    }

    /**
     * @param DemoEvent $event
     * @param array $allStats
     * @param array $trackedPlayers
     * @param Demo $demo
     * @return array
     */
    private function analyzeBombDefused(DemoEvent $event, array $allStats, array $trackedPlayers, Demo $demo) {
        $data = $event->getData();
        $userId = $data[self::ENAME_USER_ID];

        $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
        $playerStats->addBombDefuse();
        $this->setPlayerStats($allStats, $userId, $playerStats);

        return $allStats;
    }

    /**
     * @param DemoEvent $event
     * @param DemoStats[] $allStats
     * @param array $trackedPlayers
     * @param Demo $demo
     * @return DemoStats[]
     */
    private function analyzeMvp(DemoEvent $event, array $allStats, array $trackedPlayers, Demo $demo) {
        $data = $event->getData();
        if (in_array($data[self::ENAME_USER_ID], $trackedPlayers)) {
            $userId = $data[self::ENAME_USER_ID];

            $playerStats = $this->getPlayerStats($allStats, $userId, $demo);
            $playerStats->addMvp();
            $allStats = $this->setPlayerStats($allStats, $userId, $playerStats);
        }

        return $allStats;
    }

    /**
     * @param array $allStats
     * @param int $playerId
     * @param Demo $demo
     * @return DemoStats
     */
    private function getPlayerStats(array $allStats, $playerId, Demo $demo) {
        if (!array_key_exists($playerId, $allStats) || !$allStats[$playerId] instanceof DemoStats) {
            $playerStats = new DemoStats();
            $playerStats->setDemoId($demo->getId())
                ->setUserId($playerId);

            $player = $demo->getMatchInfo()->getPlayerByUserId($playerId);
            if ($player) {
                $playerStats->setSteamId64($player->getSteamId64());
            }

            $allStats[$playerId] = $playerStats;
        }

        return $allStats[$playerId];
    }

    /**
     * @param DemoStats[] $allStats
     * @param $playerId
     * @param DemoStats $stats
     * @return DemoStats[]
     */
    private function setPlayerStats(array $allStats, $playerId, DemoStats $stats) {
        $allStats[$playerId] = $stats;
        return $allStats;
    }
}