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
        return $this->dm->getRepository('OverwatchBundle:OverwatchUserScore');
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
     * @return OverwatchUserScore[]
     */
    public function findByUser(User $user) {
        return $this->getRepository()->findBy(['user_id' => $user->getId()]);
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
        return $this->getRepository()->findBy(['user_id' => $userId, 'period' => $period]);
    }
}