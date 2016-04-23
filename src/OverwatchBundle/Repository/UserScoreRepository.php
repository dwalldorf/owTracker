<?php

namespace OverwatchBundle\Repository;

use AppBundle\Repository\BaseRepository;
use OverwatchBundle\Document\UserScore;
use UserBundle\Document\User;

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
        return $this->dm->createQueryBuilder(self::ID);
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
    }

    /**
     * @param User $user
     * @param int $period
     * @return UserScore|\OverwatchBundle\Document\UserScore[]
     */
    public function findByUser(User $user, $period = null) {
        $criteria = ['user_id' => $user->getId()];

        if ($period) {
            $criteria['period'] = $period;
        }
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @param User $user
     * @param int $period
     * @return UserScore
     */
    public function findByUserAndPeriod(User $user, $period = 1) {
        $criteria = [
            'user_id' => $user->getId(),
            'period'  => $period,
        ];

        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * @param int $period
     * @return UserScore[]
     */
    public function getTopTen($period) {
        $scores = $this->getQueryBuilder()
            ->field('period')->equals($period)
            ->limit(10)
            ->sort('count', 'desc')
            ->eagerCursor(true)
            ->getQuery()
            ->execute()
            ->toArray();

        return $scores;
    }

    /**
     * @param UserScore $userScore
     * @param int $period
     * @return \OverwatchBundle\Document\UserScore[]
     */
    public function getNextTen(UserScore $userScore, $period) {
        $scores = $this->getQueryBuilder()
            ->field('period')->equals($period)
            ->field('count')->lt($userScore->getNumberOfOverwatches())
            ->limit(10)
            ->sort('count', 'desc')
            ->eagerCursor(true)
            ->getQuery()
            ->execute()
            ->toArray();

        return $scores;
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