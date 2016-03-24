<?php

namespace UserBundle\Service;

use AppBundle\Service\BaseService;
use UserBundle\Document\User;

class UserService extends BaseService {

    const SERVICE_NAME = 'user.user_service';

    /**
     * @param User $user
     */
    public function register(User $user) {
    }

}