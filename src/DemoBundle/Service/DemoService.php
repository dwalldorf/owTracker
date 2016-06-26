<?php

namespace DemoBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
use AppBundle\Service\BaseService;
use DemoBundle\Document\Demo;
use DemoBundle\Document\MatchInfo;
use DemoBundle\Document\MatchTeam;
use DemoBundle\Repository\DemoRepository;
use OverwatchBundle\Service\OverwatchService;

class DemoService extends BaseService {

    const ID = 'demo.demo_service';

    /**
     * @var DemoRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(DemoRepository::ID);
    }

    /**
     * @param Demo $demo
     * @return Demo
     *
     * @throws InvalidArgumentException
     */
    public function save(Demo $demo) {
        return $this->repository->save($demo);
    }

    /**
     * @param string $userId
     * @return Demo[]
     */
    public function getByUser($userId) {
        return $this->repository->findByUserId($userId);
    }

    /**
     * @param Demo $demo
     * @return array
     */
    private function validateDemo(Demo $demo) {
        $errors = [];

        if (!$demo) {
            $errors['error'] = 'no data submitted';
            return $errors;
        }

        if (!$demo->getMatchInfo() instanceof MatchInfo) {
            $errors['matchinfo'] = 'no matchinfo submitted';
        } else {
            $matchInfo = $demo->getMatchInfo();
            if (!$matchInfo->getTeam1() instanceof MatchTeam || !$matchInfo->getTeam2() instanceof MatchTeam) {
                $errors['teams'] = 'missing or corrupt team information submitted';
            }
            if (!$matchInfo->getMap()) {
                $errors['map'] = 'missing or invalid map';
            } else {
                if (!in_array($matchInfo->getMap(), OverwatchService::getMapPool())) {
                    $errors['map'] = 'invalid map "' . $matchInfo->getMap() . '"';
                }
            }
        }

        return $errors;
    }
}