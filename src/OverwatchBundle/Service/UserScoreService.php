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
     * @return UserScore|UserScore[]
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
        $userScore = $this->getByUserId($userId, $period);
        $scores = $this->repository->getHigherThan($userScore, $period, $limit + 1, $offset);

        return $this->createScoreCollection($scores, $limit);
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
        $scores = $this->repository->getLowerThan($userScore, $period, $limit + 1, $offset);

        return $this->createScoreCollection($scores, $limit);
    }

    /**
     * @param int $period
     * @return UserScore[]
     */
    public function findByPeriod($period) {
        return $this->repository->findByPeriod($period);
    }

    /**
     * @param UserScore|UserScore[] $scores
     * @return UserScoreDto[]
     */
    public function toDto($scores) {
        if ($scores && !is_array($scores)) {
            $scores = [$scores];
        }

        $retVal = [];
        foreach ($scores as $score) {
            $user = $this->userService->findById($score->getUserId());
            if ($user) {
                $dto = new UserScoreDto();
                $dto->setUsername($user->getUsername());
                $dto->setPosition($score->getPosition());
                $dto->setScore($score->getVerdicts());
                $dto->setPeriod($score->getPeriod());

                $retVal[] = $dto;
            }
        }
        return $retVal;
    }

    /**
     * @param UserScore[] $scores
     * @param int $limit
     * @return UserScoreCollection
     * @throws \Exception
     */
    private function createScoreCollection(array $scores, $limit) {
        $scoreCollection = new UserScoreCollection();
        $dtos = $this->toDto($scores);

        if (count($dtos) > $limit) {
            $scoreCollection->setHasMore(true);
            array_pop($dtos);

            // should never happen (tm)
            if (count($dtos) > $limit) {
                throw new \Exception('0x0ff1a3');
            }
        }
        $scoreCollection->setItems($dtos);

        return $scoreCollection;
    }
}