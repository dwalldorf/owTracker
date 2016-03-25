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
        ldd($this->repository);
    }

    /**
     * @param User $user
     */
    public function register(User $user) {
        ldd($this->repository);
    }

}