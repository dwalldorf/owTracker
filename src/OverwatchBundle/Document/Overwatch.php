<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="overwatch", repositoryClass="OverwatchBundle\Repository\OverwatchRepository")
 */
class Overwatch {

    private $mapPool = [
        0  => 'de_dust2',
        1  => 'de_inferno',
        2  => 'de_nuke',
        3  => 'de_train',
        4  => 'de_mirage',
        5  => 'de_cache',
        6  => 'de_cbbl',
        7  => 'de_overpass',
        8  => 'de_tuscan',
        9  => 'de_season',
        10 => 'de_santorini',
    ];

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
     * @ODM\Date(nullable=false)
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @ODM\String(nullable=false)
     * @var string
     */
    private $map;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $aimAssist = false;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $visionAssist = false;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $otherAssist = false;

    /**
     * @ODM\Bool(nullable=false)
     * @var bool
     */
    private $griefing = false;

    public function __construct() {
        $this->setCreationDate(new \DateTime());
    }

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
     * @return \DateTime
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
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

    /**
     * @return array
     */
    public function getMapPool() {
        return $this->mapPool;
    }

    /**
     * @return bool
     */
    public function hasValidMap() {
        if (array_search($this->getMap(), $this->getMapPool()) !== false) {
            return true;
        }
        return false;
    }
}