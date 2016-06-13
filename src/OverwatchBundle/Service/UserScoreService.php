<?php

namespace OverwatchBundle\Service;

use AppBundle\Model\CacheKey;
use AppBundle\Service\BaseService;
use AppBundle\Service\CacheService;
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
     * @var CacheService
     */
    private $cacheService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserScoreRepository
     */
    private $repository;

    protected function init() {
        $this->cacheService = $this->getService(CacheService::ID);
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
        $cacheKey = new CacheKey('scores:%s:%d', $userId, $period);
        $cacheHit = $this->cacheService->get($cacheKey);

        if ($cacheHit !== false) {
            return $cacheHit;
        }

        $retVal = $this->repository->findByUserId($userId, $period);
        if (!$retVal) {
            return null;
        }

        if (count($retVal) == 1) {
            $retVal = $retVal[0];
        }
        return $this->cacheService->set($cacheKey, $retVal, 30);
    }

    /**
     * @param string $userId
     * @param int $period
     * @param int $limit
     * @param int $offset
     * @return UserScoreCollection
     */
    public function getHigherThan($userId, $period, $limit, $offset) {
        $retVal = new UserScoreCollection();
        $userScore = $this->getByUserId($userId, $period);

        if (!$userScore) {
            return $retVal;
        }
        $position = $userScore->getPosition();

        $cacheKey = new CacheKey('scores:higher:%d:%d:%d:%d', $position, $period, $offset, $limit);
        $cacheHit = $this->cacheService->get($cacheKey);
        if ($cacheHit !== false) {
            return $cacheHit;
        }

        $scores = $this->repository->getHigherThan($position, $period, $limit + 1, $offset);
        $dtos = $this->toDto($scores);
        $retVal->setItems($dtos, $limit);

        return $this->cacheService->set($cacheKey, $retVal, 30);
    }

    /**
     * @param string $userId
     * @param int $period
     * @param int $limit
     * @param int $offset
     * @return UserScore[]
     */
    public function getLowerThan($userId, $period, $limit = 10, $offset = 0) {
        $retVal = new UserScoreCollection();
        $userScore = $this->getByUserId($userId, $period);
        $actualLimit = $limit;

        if ($userScore) {
            $position = $userScore->getPosition();
            $actualLimit++;
        } else {
            $position = 0;
        }

        $cacheKey = new CacheKey('scores:lower:%d:%d:%d:%d', $position, $period, $offset, $limit);
        $cacheHit = $this->cacheService->get($cacheKey);
        if ($cacheHit !== false) {
            return $cacheHit;
        }

        $scores = $this->repository->getLowerThan($position, $period, $actualLimit, $offset);
        $dtos = $this->toDto($scores);
        $retVal->setItems($dtos, $limit);

        return $this->cacheService->set($cacheKey, $retVal, 30);
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
        $retVal = [];

        if ($scores && !is_array($scores)) {
            $scores = [$scores];
        }

        foreach ($scores as $score) {
            $dto = new UserScoreDto();

            if ($score->getUserId()) {
                $user = $this->userService->findById($score->getUserId());
                if ($user) {
                    $dto->setUsername($user->getUsername());
                }
            }

            $dto->setPosition($score->getPosition());
            $dto->setScore($score->getVerdicts());
            $dto->setPeriod($score->getPeriod());

            $retVal[] = $dto;
        }
        return $retVal;
    }
}