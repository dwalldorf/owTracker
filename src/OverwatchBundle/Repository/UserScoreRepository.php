<?php

namespace OverwatchBundle\Repository;

use AppBundle\Repository\BaseRepository;
use OverwatchBundle\Document\UserScore;

class UserScoreRepository extends BaseRepository {

    const ID = 'OverwatchBundle:UserScore';

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
        return $this->getRepository()->dm->createQueryBuilder(self::ID);
    }

    /**
     * @param UserScore $userScore
     */
    public function save(UserScore $userScore) {
        $oldUserScore = $this->findByUserIdAndPeriod($userScore->getUserId(), $userScore->getPeriod());
        if ($oldUserScore) {
            $this->remove($oldUserScore);
        }

        $this->dm->persist($userScore);
        $this->dm->flush();
        $this->dm->clear();
    }

    /**
     * @param string $userId
     * @param int $period
     * @return UserScore[]
     */
    public function findByUserId($userId, $period = null) {
        $criteria = [
            'user_id' => $userId,
            'period'  => $period,
        ];

        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @param int $period
     * @return UserScore[]
     */
    public function findByPeriod($period) {
        return $this->getQueryBuilder()
            ->field('period')->equals($period)
            ->sort('verdicts', -1)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * @param UserScore $higherThan
     * @param int $period
     * @param int $limit
     * @param int $offset
     *
     * @return UserScore[]
     */
    public function getHigherThan(UserScore $higherThan, $period, $limit = 10, $offset = 0) {
        $res = $this->getQueryBuilder()
            ->field('user_id')->notEqual($higherThan->getUserId())
            ->field('period')->equals($period)
            ->field('position')->lt($higherThan->getPosition())
            ->skip($offset)
            ->limit($limit)
            ->sort('position', 'asc')
            ->getQuery()
            ->execute()
            ->toArray();

        return array_values($res);
    }

    /**
     * @param UserScore $lowerThan
     * @param int $period
     * @param int $limit
     * @param int $offset
     * @return UserScore[]
     */
    public function getLowerThan(UserScore $lowerThan, $period, $limit = 10, $offset = 0) {
        $res = $this->getQueryBuilder()
            ->field('user_id')->notEqual($lowerThan->getUserId())
            ->field('period')->equals($period)
            ->field('position')->gt($lowerThan->getPosition())
            ->sort('position', 'asc')
            ->skip($offset)
            ->limit($limit)
            ->getQuery()
            ->execute()
            ->toArray();

        return array_values($res);
    }

    /**
     * @param UserScore $userScore
     */
    private function remove(UserScore $userScore) {
        $this->dm->remove($userScore);
    }

    /**
     * @param string $userId
     * @param int $period
     * @return UserScore
     */
    private function findByUserIdAndPeriod($userId, $period) {
        return $this->getRepository()->findOneBy(['user_id' => $userId, 'period' => $period]);
    }
}