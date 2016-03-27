<?php

namespace UserBundle\Repository;

use AppBundle\Repository\BaseRepository;
use UserBundle\Document\User;

class UserRepository extends BaseRepository {

    const ID = 'UserBundle:User';
    
    /**
     * @param User $user
     * @return int userId
     */
    public function register(User $user) {
        $this->dm->persist($user);
        $this->dm->flush();

        return $user->getId();
    }
}