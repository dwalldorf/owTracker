<?php

namespace FeedbackBundle\Repository;

use AppBundle\Repository\BaseRepository;
use FeedbackBundle\Document\Feedback;

class FeedbackRepository extends BaseRepository {

    const ID = 'FeedbackBundle:Feedback';

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
     * @return Feedback[]
     */
    public function getAll() {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Feedback $feedback
     * @return Feedback
     */
    public function save(Feedback $feedback) {
        $this->dm->persist($feedback);
        $this->dm->flush();

        return $feedback;
    }

    /**
     * @param string $userId
     */
    public function deleteByUserId($userId) {
        $this->getQueryBuilder()
            ->remove()
            ->field('created_by')->equals($userId)
            ->getQuery()
            ->execute();
    }
}