<?php

namespace OverwatchBundle\Repository;

use AppBundle\Repository\BaseRepository;
use OverwatchBundle\Document\OverwatchUserScore;
use UserBundle\Document\User;

class OverwatchUserScoreRepository extends BaseRepository {

    const ID = 'OverwatchBundle:OverwatchUserScore';

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
     * @param OverwatchUserScore $userScore
     */
    public function save(OverwatchUserScore $userScore) {
        $oldUserScore = $this->findByUserIdAndPeriod($userScore->getUserId(), $userScore->getPeriod());
        if ($oldUserScore) {
            $this->remove($oldUserScore);
        }

        $this->dm->persist($userScore);
        $this->dm->flush();
    }

    /**
     * @param User $user
     * @return OverwatchUserScore | OverwatchUserScore[]
     */
    public function findByUser(User $user) {
        return $this->getRepository()->findBy(['user_id' => $user->getId()]);
    }

    /**
     * @param User $user
     * @param int $period
     * @return OverwatchUserScore
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
     * @return OverwatchUserScore[]
     */
    public function getTopTen($period) {
        $scores = $this->getQueryBuilder()
            ->field('period')->equals($period)
            ->limit(10)
            ->sort('number_of_overwatches', 'desc')
            ->eagerCursor(true)
            ->getQuery()
            ->execute()
            ->toArray();

        return $scores;
    }

    /**
     * @param OverwatchUserScore $userScore
     * @param int $period
     * @return \OverwatchBundle\Document\OverwatchUserScore[]
     */
    public function getNextTen(OverwatchUserScore $userScore, $period) {
        $scores = $this->getQueryBuilder()
            ->field('period')->equals($period)
            ->field('number_of_overwatches' < $userScore->getNumberOfOverwatches())
            ->limit(10)
            ->sort('number_of_overwatches', 'desc')
            ->eagerCursor(true)
            ->getQuery()
            ->execute()
            ->toArray();

        return $scores;
    }

    /**
     * @param OverwatchUserScore $userScore
     */
    private function remove(OverwatchUserScore $userScore) {
        $this->dm->remove($userScore);
    }

    /**
     * @param string $userId
     * @param int $period
     * @return OverwatchUserScore
     */
    private function findByUserIdAndPeriod($userId, $period) {
        return $this->getRepository()->findOneBy(['user_id' => $userId, 'period' => $period]);
    }
}