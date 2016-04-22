<?php

namespace OverwatchBundle\Service;

use AppBundle\Service\BaseService;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\DTO\OverwatchScoreboard;
use OverwatchBundle\Repository\OverwatchUserScoreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Document\User;

class OverwatchUserScoreService extends BaseService {

    const ID = 'overwatch.overwatch_user_score_service';

    const PERIOD_ALL_TIME = 'all time';

    const PERIOD_LAST_24H = 'last 24h';

    const PERIOD_LAST_7_DAYS = 'last 7 days';

    const PERIOD_LAST_30_DAYS = 'last 30 days';

    /**
     * @var array
     */
    private static $periods = [
        self::PERIOD_ALL_TIME     => 0,
        self::PERIOD_LAST_24H     => 1,
        self::PERIOD_LAST_7_DAYS  => 7,
        self::PERIOD_LAST_30_DAYS => 30,
    ];

    /**
     * @var OverwatchUserScoreRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(OverwatchUserScoreRepository::ID);
    }

    /**
     * @return array [name => int value]
     */
    public function getAvailablePeriods() {
        return self::$periods;
    }

    /**
     * @param string $periodName
     * @return int
     */
    public function getPeriod($periodName) {
        return self::$periods[$periodName];
    }

    /**
     * @param OverwatchUserScore $userScore
     */
    public function save(OverwatchUserScore $userScore) {
        $this->repository->save($userScore);
    }

    /**
     * @return OverwatchUserScore[]
     */
    public function getAll() {
        return $this->repository->findAll();
    }

    /**
     * @param User $user
     * @param int $period
     * @return array|OverwatchUserScore
     */
    public function getByUser(User $user, $period = null) {
        $retVal = $this->repository->findByUser($user, $period);

        if (count($retVal) === 1) {
            $retVal = $retVal[0];
        }

        return $retVal;
    }

    /**
     * @param $period
     * @return OverwatchUserScore[]
     */
    public function getTopTen($period) {
        return $this->repository->getTopTen($period);
    }

    /**
     * @param OverwatchUserScore $userScore
     * @param int $period
     * @return OverwatchUserScore[]
     */
    public function getNextTen(OverwatchUserScore $userScore, $period) {
        return $this->repository->getNextTen($userScore, $period);
    }
}