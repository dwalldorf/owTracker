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
        return $this->getQueryBuilder()
            ->field('user_id')->equals($userId)
            ->sort('creationDate', 'desc')
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * @param string $userId
     */
    public function deleteByUserId($userId) {
        $this->getQueryBuilder()
            ->remove()
            ->field('userId')->equals($userId)
            ->getQuery()
            ->execute();
    }

    public function getUserscores($period = null) {
        $qb = $this->getQueryBuilder();

        if ($period) {
            $beforeDate = new \MongoDate(strtotime(sprintf('-%d days', $period)));
            $qb->field('creationDate')->gte($beforeDate);
        }

        return $qb->map('function() { emit(this.user_id, 1); }')
            ->reduce(
                'function(k, values) {
                var sum = 0;
                for (var i in values) {
                    sum = sum + 1;
                }
                return sum;
            }'
            )
            ->getQuery()
            ->execute()
            ->toArray();
    }
}