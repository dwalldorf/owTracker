<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt", 
 *     collection="overwatch", 
 *     repositoryClass="OverwatchBundle\Repository\OverwatchRepository"
 * )
 */
class Overwatch {

    /*
     * TODO: just duplicate this in js, remove mappool endpoint
     * by dwalldorf at 01:06 02.04.16
     */
    private static $mapPool = [
        0  => ['id' => 0, 'name' => 'de_dust2'],
        1  => ['id' => 1, 'name' => 'de_inferno'],
        2  => ['id' => 2, 'name' => 'de_nuke'],
        3  => ['id' => 3, 'name' => 'de_train'],
        4  => ['id' => 4, 'name' => 'de_mirage'],
        5  => ['id' => 5, 'name' => 'de_cache'],
        6  => ['id' => 6, 'name' => 'de_cbbl'],
        7  => ['id' => 7, 'name' => 'de_overpass'],
        8  => ['id' => 8, 'name' => 'de_tuscan'],
        9  => ['id' => 9, 'name' => 'de_season'],
        10 => ['id' => 10, 'name' => 'de_santorini'],
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
     * @ODM\Date(nullable=false)
     * @var \DateTime
     */
    private $overwatchDate;

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

    /**
     * not persisted
     *
     * @var string
     */
    private $displayDate;

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
     * @return \DateTime
     */
    public function getOverwatchDate() {
        return $this->overwatchDate;
    }

    /**
     * @param \DateTime $overwatchDate
     */
    public function setOverwatchDate($overwatchDate) {
        $this->overwatchDate = $overwatchDate;
    }

    /**
     * @return string
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * @param array $map
     */
    public function setMap(array $map) {
        $this->map = self::$mapPool[$map['id']]['name'];
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
    public static function getMapPool() {
        return self::$mapPool;
    }

    /**
     * @return string
     */
    public function getDisplayDate() {
        return $this->displayDate;
    }

    /**
     * @param string $displayDate
     */
    public function setDisplayDate($displayDate) {
        $this->displayDate = $displayDate;
    }

    /**
     * @return bool
     */
    public function hasValidMap() {
        foreach (self::$mapPool as $map) {
            if ($map['name'] == $this->map) {
                return true;
            }
        }
        return false;
    }
}