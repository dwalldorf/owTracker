<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="demo_stats",
 *     repositoryClass="DemoBundle\Repository\DemoStatsRepository"
 * )
 */
class DemoStats {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string", name="demo_id")
     */
    private $demoId;

    /**
     * @var string
     * @ODM\Field(type="string", name="user_id")
     */
    private $userId;

    /*
     * TODO: think of all the stats to collect per match 
     * by dwalldorf at 19:36 21.08.16
     */

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDemoId() {
        return $this->demoId;
    }

    /**
     * @param string $demoId
     * @return $this
     */
    public function setDemoId($demoId) {
        $this->demoId = $demoId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return $this
     */
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }
}