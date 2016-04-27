<?php

namespace OverwatchBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
use AppBundle\Service\BaseService;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Repository\OverwatchRepository;
use UserBundle\Document\User;

class OverwatchService extends BaseService {

    /**
     * @var array
     */
    private static $mapPool = [
        'de_dust2',
        'de_inferno',
        'de_nuke',
        'de_train',
        'de_mirage',
        'de_cache',
        'de_cbbl',
        'de_overpass',
        'de_tuscan',
        'de_season',
        'de_santorini',
    ];

    const ID = 'overwatch.overwatch_service';

    /**
     * @var OverwatchRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(OverwatchRepository::ID);
    }

    /**
     * @return array
     */
    public static function getMapPool() {
        return self::$mapPool;
    }

    /**
     * @param Verdict $verdict
     * @return Verdict
     * @throws InvalidArgumentException
     */
    public function save(Verdict $verdict) {
        $errors = $this->validateVerdict($verdict);
        if ($errors) {
            throw new InvalidArgumentException('invalid map');
        }

        $dbVerdict = $this->repository->save($verdict);
        return $this->prepareDto($dbVerdict);
    }

    /**
     * @param string $userId
     * @return Verdict[]
     */
    public function getByUserId($userId) {
        $verdicts = $this->repository->getByUserId($userId);
        return $this->prepareDtoList($verdicts);
    }

    /**
     * @param User $user
     */
    public function deleteByUser(User $user) {
        $this->repository->deleteByUser($user->getId());
    }

    /**
     * @param Verdict[] $verdicts
     * @return Verdict[]
     */
    private function prepareDtoList(array $verdicts) {
        $retVal = [];
        $count = 0;

        foreach ($verdicts as $verdict) {
            $verdict = $this->prepareDto($verdict);
            $retVal[] = $verdict;

            $count++;
        }

        return $retVal;
    }

    /**
     * @param Verdict $verdict
     * @return Verdict
     */
    private function prepareDto(Verdict $verdict) {
        $dateFormat = 'Y-m-d H:i';

        $verdict->setDisplayDate($verdict->getCreationDate()->format($dateFormat));
        return $verdict;
    }

    /**
     * @param Verdict $verdict
     * @return array|null
     */
    private function validateVerdict(Verdict $verdict) {
        $errors = [];

        if (!in_array($verdict->getMap(), self::$mapPool)) {
            $errors['map'] = 'invalid map';
        }

        if (count($errors) > 0) {
            return $errors;
        }
        return null;
    }
}