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
     * @Int(nullable=false)
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
    private $calculatedInMs;

    /**
     * @Int(nullable=false)
     * @var int
     */
    private $position;

    /**
     * @Int(nullable=false)
     * @var int
     */
    private $verdicts = 0;

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
    public function getCalculatedInMs() {
        return $this->calculatedInMs;
    }

    /**
     * @param float $calculatedInMs
     */
    public function setCalculatedInMs($calculatedInMs) {
        $this->calculatedInMs = $calculatedInMs;
    }

    /**
     * @return int
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position) {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getVerdicts() {
        return $this->verdicts;
    }

    /**
     * @param int $verdicts
     */
    public function setVerdicts($verdicts) {
        $this->verdicts = $verdicts;
    }

    public function addOverwatch() {
        $this->verdicts++;
    }
}