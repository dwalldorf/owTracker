<?php

namespace OverwatchBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
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

    /**
     * @param Overwatch $overwatch
     * @return Overwatch
     * @throws InvalidArgumentException
     */
    public function save(Overwatch $overwatch) {
        $errors = $this->validateOverwatch($overwatch);
        if ($errors) {
            throw new InvalidArgumentException('invalid map');
        }

        $overwatch->setUserId($this->getCurrentUser()->getId());

        return $this->repository->save($overwatch);
    }

    /**
     * @param User $user
     * @return Overwatch[]
     */
    public function getByUser(User $user) {
        return $this->repository->getByUserId($user->getId());
    }

    /**
     * @param Overwatch $overwatch
     * @return array|null
     */
    private function validateOverwatch(Overwatch $overwatch) {
        $errors = [];

        if (!$overwatch->hasValidMap()) {
            $errors['map'] = 'invalid map';
        }

        if (count($errors) > 0) {
            return $errors;
        }
        return null;
    }
}