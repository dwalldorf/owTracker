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

    /**
     * @var OverwatchUserScoreRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(OverwatchUserScoreRepository::ID);
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
     * @return OverwatchUserScore[]
     */
    public function getByUser(User $user) {
        return $this->repository->findByUser($user);
    }

    /**
     * @param int $period
     * @return OverwatchScoreboard
     */
    public function getScoreboard($period) {
        $top10 = $this->repository->getTopTen($period);
        $userScore = $this->repository->findByUserAndPeriod($this->getCurrentUser(), $period);
        $next10 = $this->repository->getNextTen($userScore, $period);

        return new OverwatchScoreboard($period, $top10, $userScore, $next10);
    }
}