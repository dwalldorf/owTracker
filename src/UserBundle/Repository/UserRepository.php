<?php

namespace UserBundle\Repository;

use AppBundle\Repository\BaseRepository;
use UserBundle\Document\User;

class UserRepository extends BaseRepository {

    const ID = 'UserBundle:User';

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentRepository
     */
    private function getRepository() {
        return $this->dm->getRepository('UserBundle:User');
    }
    
    /**
     * @param User $user
     * @return int userId
     */
    public function register(User $user) {
        $this->dm->persist($user);
        $this->dm->flush();

        return $user->getId();
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail($email) {
        return $this->getRepository()->findOneBy(['email' => $email]);
    }

    /**
     * @return User[]
     */
    public function getAll() {
        return $this->getRepository()->findAll();
    }
}