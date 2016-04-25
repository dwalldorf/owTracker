<?php

namespace OverwatchBundle\Service;

use AppBundle\Service\BaseService;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\DTO\UserScoreCollection;
use OverwatchBundle\DTO\UserScoreDto;
use OverwatchBundle\Repository\UserScoreRepository;
use UserBundle\Service\UserService;

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
     * @var UserService
     */
    private $userService;

    /**
     * @var UserScoreRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(UserScoreRepository::ID);
        $this->userService = $this->getService(UserService::ID);
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
     * @return array|UserScoreDto
     */
    public function getByUserId($userId, $period = null) {
        $retVal = $this->toDto($this->repository->findByUserId($userId, $period));

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

        $userVerdicts = $this->getUserScoreVerdictCount($userId, $period);
        $scores = $this->repository->getHigherThan($userVerdicts, $period, $limit + 1, $offset);

        /*
         * TODO: fix hasMore
         * by dwalldorf at 19:55 25.04.16
         */
        $scoreCollection->setScores($this->toDto($scores, $limit));

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
        $scoreCollection = new UserScoreCollection();

        $userVerdicts = $this->getUserScoreVerdictCount($userId, $period);
        $scores = $this->repository->getLowerThan($userVerdicts, $period, $limit + 1, $offset);

        $scoreCollection->setScores($this->toDto($scores, $limit));

        return $scoreCollection;
    }

    /**
     * @param string $userId
     * @param int $period
     * @return int
     */
    private function getUserScoreVerdictCount($userId, $period) {
        $userScore = $this->getByUserId($userId, $period);

        if (!$userScore) {
            return 0;
        }
        return $userScore->getScore();
    }

    /**
     * @param UserScore[] $scores
     * @param int $limit
     * @return UserScoreDto[]
     */
    private function toDto(array $scores, $limit = null) {
        $retVal = [];
        $count = 0;

        foreach ($scores as $score) {
            if ($limit && $count >= $limit) {
                break;
            }

            $user = $this->userService->findById($score->getUserId());

            $dto = new UserScoreDto();
            $dto->setUsername($user->getUsername());
            $dto->setScore($score->getVerdicts());

            $retVal[] = $dto;
            $count++;
        }
        return $retVal;
    }
}