<?php

namespace DemoBundle\Repository;

use AppBundle\Repository\BaseRepository;
use DemoBundle\Document\Demo;

class DemoRepository extends BaseRepository {

    const ID = 'DemoBundle:Demo';

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
     * @param Demo $demo
     * @return Demo
     */
    public function save(Demo $demo) {
        $this->dm->persist($demo);
        $this->dm->flush();

        return $demo;
    }

    /**
     * @param string $userId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findByUserId($userId, $limit, $offset) {
        return $this->getQueryBuilder()
            ->select('id', 'matchInfo.team1', 'matchInfo.team2', 'matchInfo')
            ->field('user_id')->equals($userId)
            ->limit($limit)
            ->skip($offset)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}