<?php

namespace OverwatchBundle\Repository;

use AppBundle\Repository\BaseRepository;
use OverwatchBundle\Document\Verdict;

class OverwatchRepository extends BaseRepository {

    const ID = 'OverwatchBundle:Verdict';

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
     * @param Verdict $verdict
     * @return Verdict
     */
    public function save(Verdict $verdict) {
        $this->dm->persist($verdict);
        $this->dm->flush();

        return $verdict;
    }

    /**
     * @param string $userId
     * @return Verdict[]
     */
    public function getByUserId($userId) {
        return $this->getRepository()->findBy(['user_id' => $userId]);
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