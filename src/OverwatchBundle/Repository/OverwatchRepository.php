<?php

namespace OverwatchBundle\Repository;

use AppBundle\Repository\BaseRepository;
use OverwatchBundle\Document\Overwatch;

class OverwatchRepository extends BaseRepository {

    const ID = 'OverwatchBundle:Overwatch';

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
     * @param Overwatch $overwatch
     * @return Overwatch
     */
    public function save(Overwatch $overwatch) {
        $this->dm->persist($overwatch);
        $this->dm->flush();

        return $overwatch;
    }

    /**
     * @param string $userId
     * @return Overwatch[]
     */
    public function getByUserId($userId) {
        return $this->getRepository()->findBy(['userId' => $userId]);
    }

    /**
     * @param string $userId
     */
    public function deleteByUser($userId) {
        $this->getQueryBuilder()
            ->remove()
            ->field('userId')->equals($userId)
            ->getQuery()
            ->execute();
    }
}