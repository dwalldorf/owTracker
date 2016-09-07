<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use DemoBundle\Document\DemoStats;
use DemoBundle\Repository\DemoStatsRepository;

class DemoStatsService extends BaseService {

    const ID = 'demo.demo_stats_service';

    /**
     * @var DemoStatsRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(DemoStatsRepository::ID);
    }

    /**
     * @param DemoStats[] $stats
     * @return DemoStats[]
     */
    public function save(array $stats) {
        return $this->repository->save($stats);
    }
}