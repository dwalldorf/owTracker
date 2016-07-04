<?php

namespace DemoBundle\Repository;

use AppBundle\Repository\BaseRepository;
use DemoBundle\Document\DemoFile;

class DemoFileRepository extends BaseRepository {

    const ID = 'DemoBundle:DemoFile';

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
     * @param DemoFile $demoFile
     * @return DemoFile
     */
    public function save(DemoFile $demoFile) {
        $this->dm->persist($demoFile);
        $this->dm->flush();

        return $demoFile;
    }
}