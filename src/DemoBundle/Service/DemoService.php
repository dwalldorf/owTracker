<?php

namespace DemoBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
use AppBundle\Service\BaseService;
use DemoBundle\Document\Demo;
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
}