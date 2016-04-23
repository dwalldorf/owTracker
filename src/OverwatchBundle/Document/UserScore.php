<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Float;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Int;
use Doctrine\ODM\MongoDB\Mapping\Annotations\String;

/**
 * @Document(
 *     db="owt",
 *     collection="user_scores",
 *     repositoryClass="OverwatchBundle\Repository\UserScoreRepository"
 * )
 */
class UserScore {

    /**
     * @Id
     * @var string
     */
    private $id;

    /**
     * @Int
     * @var int
     */
    private $period;

    /**
     * @String(name="user_id", nullable=false)
     * @var string
     */
    private $userId;

    /**
     * @Date(nullable=false)
     * @var \DateTime
     */
    private $calculated;

    /**
     * @Float(nullable=false)
     * @var float
     */
    private $calulatedInMs;

    /**
     * @Int(name="count", nullable=false)
     * @var int
     */
    private $numberOfOverwatches = 0;

    /**
     * @param int $period
     * @param string $userId
     */
    public function __construct($period, $userId = null) {
        $this->period = $period;
        $this->userId = $userId;
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
     * @return int
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * @param int $period
     */
    public function setPeriod($period) {
        $this->period = $period;
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
    public function getCalculated() {
        return $this->calculated;
    }

    /**
     * @param \DateTime $calculated
     */
    public function setCalculated($calculated) {
        $this->calculated = $calculated;
    }

    /**
     * @return float
     */
    public function getCalulatedInMs() {
        return $this->calulatedInMs;
    }

    /**
     * @param float $calulatedInMs
     */
    public function setCalulatedInMs($calulatedInMs) {
        $this->calulatedInMs = $calulatedInMs;
    }

    /**
     * @return int
     */
    public function getNumberOfOverwatches() {
        return $this->numberOfOverwatches;
    }

    /**
     * @param int $numberOfOverwatches
     */
    public function setNumberOfOverwatches($numberOfOverwatches) {
        $this->numberOfOverwatches = $numberOfOverwatches;
    }

    public function addOverwatch() {
        $this->numberOfOverwatches++;
    }
}