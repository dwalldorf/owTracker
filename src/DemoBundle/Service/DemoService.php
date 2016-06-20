<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use DemoBundle\Document\DemoInfo;
use DemoBundle\Repository\DemoRepository;

class DemoService extends BaseService {

    const ID = 'demo.demo_service';

    /**
     * @var DemoRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(DemoRepository::ID);
    }

    public function save(DemoInfo $demo) {
        return $this->repository->save($demo);
    }

    /**
     * @param string $userId
     * @return DemoInfo[]
     */
    public function getByUser($userId) {
        return $this->repository->findByUserId($userId);
    }
}