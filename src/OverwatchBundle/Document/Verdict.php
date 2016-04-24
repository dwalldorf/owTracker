<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt",
 *     collection="verdicts",
 *     repositoryClass="OverwatchBundle\Repository\OverwatchRepository"
 * )
 */
class Verdict {

    /**
     * @ODM\Id
     * @var string
     */
    private $id;

    /**
     * @ODM\String(name="user_id", nullable=false)
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
}