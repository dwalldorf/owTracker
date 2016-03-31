<?php

namespace OverwatchBundle\Service;

use AppBundle\Service\BaseService;
use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Repository\OverwatchRepository;
use UserBundle\Document\User;

class OverwatchService extends BaseService {

    const ID = 'overwatch.overwatch_service';

    /**
     * @var OverwatchRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(OverwatchRepository::ID);
    }

    /*
     * TODO: remove
     * by dwalldorf at 20:16 28.03.16
     */
    public function getFakeOverwatchList() {
        $overwatch = new Overwatch();
        $overwatch->setId('123fake');
        $overwatch->setMap(1);
        $overwatch->setAimAssist(true);
        $overwatch->setVisionAssist(true);
        $overwatch->setOtherAssist(false);
        $overwatch->setGriefing(false);

        return [$overwatch];
    }

    /**
     * @param Overwatch $overwatch
     * @return Overwatch
     */
    public function save(Overwatch $overwatch) {
        return $this->repository->save($overwatch);
    }

    /**
     * @param User $user
     * @return Overwatch[]
     */
    public function getByUser(User $user) {
        return $this->repository->getByUserId($user->getId());
    }
}