<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="overwatch", repositoryClass="OverwatchBundle\Repository\OverwatchRepository")
 */
class Overwatch {

    /**
     * @ODM\Id
     * @var string
     */
    private $id;

    /**
     * @ODM\String(nullable=false)
     * @var string
     */
    private $userId;

    /**
     * @ODM\String(nullable=false)
     * @var string
     */
    private $map;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $aimAssist;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $visionAssist;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $otherAssist;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $griefing;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * @param string $map
     */
    public function setMap($map) {
        $this->map = $map;
    }

    /**
     * @return boolean
     */
    public function isAimAssist() {
        return $this->aimAssist;
    }

    /**
     * @param boolean $aimAssist
     */
    public function setAimAssist($aimAssist) {
        $this->aimAssist = $aimAssist;
    }

    /**
     * @return boolean
     */
    public function isVisionAssist() {
        return $this->visionAssist;
    }

    /**
     * @param boolean $visionAssist
     */
    public function setVisionAssist($visionAssist) {
        $this->visionAssist = $visionAssist;
    }

    /**
     * @return boolean
     */
    public function isOtherAssist() {
        return $this->otherAssist;
    }

    /**
     * @param boolean $otherAssist
     */
    public function setOtherAssist($otherAssist) {
        $this->otherAssist = $otherAssist;
    }

    /**
     * @return boolean
     */
    public function isGriefing() {
        return $this->griefing;
    }

    /**
     * @param boolean $griefing
     */
    public function setGriefing($griefing) {
        $this->griefing = $griefing;
    }
}