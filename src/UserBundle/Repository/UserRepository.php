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
        return $this->dm->getRepository(self::ID);
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    private function getQueryBuilder() {
        return $this->dm->createQueryBuilder(self::ID);
    }

    /**
     * @param User $user
     * @return string userId
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
     * @param string $id
     * @return User
     */
    public function findById($id) {
        return $this->getRepository()->find($id);
    }

    /**
     * @return User[]
     */
    public function getTestUsers() {
        return $this->getRepository()->findBy(['email' => new \MongoRegex('/^owtTestUser_/')]);
    }

    /**
     * @return User[]
     */
    public function getAll() {
        return $this->getRepository()->findAll();
    }

    /**
     * @param User $user
     */
    public function remove(User $user) {
        $this->getQueryBuilder()
            ->remove()
            ->field('_id')->equals($user->getId())
            ->getQuery()
            ->execute();
    }
}