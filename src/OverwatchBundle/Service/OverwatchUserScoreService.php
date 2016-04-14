<?php

namespace OverwatchBundle\Service;

use AppBundle\Service\BaseService;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\Repository\OverwatchUserScoreRepository;
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
}