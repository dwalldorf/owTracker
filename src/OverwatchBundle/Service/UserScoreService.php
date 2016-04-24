<?php

namespace OverwatchBundle\Service;

use AppBundle\Service\BaseService;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\DTO\UserScoreCollection;
use OverwatchBundle\Repository\UserScoreRepository;
use UserBundle\Document\User;

class UserScoreService extends BaseService {

    const ID = 'overwatch.user_score_service';

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
     * @var UserScoreRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(UserScoreRepository::ID);
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
     * @param UserScore $userScore
     */
    public function save(UserScore $userScore) {
        $this->repository->save($userScore);
    }

    /**
     * @return UserScore[]
     */
    public function getAll() {
        return $this->repository->findAll();
    }

    /**
     * @param string $userId
     * @param int $period
     * @return array|UserScore
     */
    public function getByUserId($userId, $period = null) {
        $retVal = $this->repository->findByUserId($userId, $period);

        if (count($retVal) === 1) {
            $retVal = $retVal[0];
        }

        return $retVal;
    }

    /**
     * @param string $userId
     * @param int $period
     * @param int $limit
     * @param int $offset
     * @return UserScoreCollection
     */
    public function getHigherThan($userId, $period, $limit, $offset) {
        $scoreCollection = new UserScoreCollection();

        $userScore = $this->getByUserId($userId, $period);
        $scores = $this->repository->getHigherThan($userScore->getVerdicts(), $period, $limit + 1, $offset);

        $limitCount = 0;
        foreach ($scores as $score) {
            if ($limitCount < $limit) {
                $scoreCollection->addScore($score);
            }
            $limitCount++;
        }

        if ($limitCount > $limit) {
            $scoreCollection->setHasMore();
        }

        return $scoreCollection;
    }

    /**
     * @param string $userId
     * @param int $period
     * @param int $limit
     * @param int $offset
     * @return UserScore[]
     */
    public function getLowerThan($userId, $period, $limit = 10, $offset = 0) {
        $userScore = $this->getByUserId($userId, $period);
        return $this->repository->getLowerThan($userScore->getVerdicts(), $period, $limit, $offset);
    }
}