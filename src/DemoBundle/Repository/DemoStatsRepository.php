<?php

namespace DemoBundle\Repository;

use AppBundle\Repository\BaseRepository;
use DemoBundle\Document\DemoStats;

class DemoStatsRepository extends BaseRepository {

    const ID = 'DemoBundle:DemoStats';

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
     * @param DemoStats[] $stats
     * @return DemoStats[]
     */
    public function save(array $stats) {
        foreach ($stats as $item) {
            $this->dm->persist($item);
        }
        $this->dm->flush();

        return $stats;
    }
}