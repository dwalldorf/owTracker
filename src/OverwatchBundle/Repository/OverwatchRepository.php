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
        return $this->dm->getRepository('OverwatchBundle:Overwatch');
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
}