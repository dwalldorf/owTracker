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

        $persistedOverwatch = $this->repository->save($overwatch);
        return $this->prepareDto($persistedOverwatch);
    }

    /**
     * @param User $user
     * @return Overwatch[]
     */
    public function getByUser(User $user) {
        $overwatchCases = $this->repository->getByUserId($user->getId());
        return $this->prepareDtoList($overwatchCases);
    }

    /**
     * @param Overwatch[] $overwatchCases
     * @return Overwatch[]
     */
    private function prepareDtoList(array $overwatchCases) {
        $retVal = [];
        $count = 0;

        foreach ($overwatchCases as $overwatchCase) {
            $overwatchCase = $this->prepareDto($overwatchCase);
            $retVal[] = $overwatchCase;

            $count++;
        }

        return $retVal;
    }

    /**
     * @param Overwatch $overwatchCase
     * @return Overwatch
     */
    private function prepareDto(Overwatch $overwatchCase) {
        $dateFormat = 'Y-m-d H:i';

        $overwatchCase->setDisplayDate($overwatchCase->getCreationDate()->format($dateFormat));
        return $overwatchCase;
    }

    /**
     * @param Overwatch $overwatch
     * @return array|null
     */
    private
    function validateOverwatch(
        Overwatch $overwatch
    ) {
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