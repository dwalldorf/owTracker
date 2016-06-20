<?php

namespace DemoBundle\Repository;

use AppBundle\Repository\BaseRepository;
use DemoBundle\Document\DemoInfo;

class DemoRepository extends BaseRepository {

    const ID = 'DemoBundle:DemoInfo';

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
     * @param DemoInfo $demo
     * @return DemoInfo
     */
    public function save(DemoInfo $demo) {
        $this->dm->persist($demo);
        $this->dm->flush();

        return $demo;
    }

    /**
     * @param string $userId
     * @return DemoInfo[]
     */
    public function findByUserId($userId) {
        return $this->getRepository()->findBy(['user_id' => $userId]);
    }
}