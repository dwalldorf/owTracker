<?php

namespace UserBundle\Service;

use AppBundle\Service\BaseService;
use UserBundle\Document\User;
use UserBundle\Repository\UserRepository;

class UserService extends BaseService {

    const SERVICE_NAME = 'user.user_service';

    /**
     * @var UserRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(UserRepository::ID);
    }

    /**
     * @param User $user
     * @return int
     */
    public function register(User $user) {
        return $this->repository->register($user);
    }

}