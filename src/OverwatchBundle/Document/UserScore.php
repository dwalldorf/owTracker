<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt",
 *     collection="user_scores",
 *     repositoryClass="OverwatchBundle\Repository\UserScoreRepository"
 * )
 */
class UserScore {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var int
     * @ODM\Int(nullable=false)
     */
    private $period;

    /**
     * @var string
     * @ODM\String(name="user_id", nullable=false)
     */
    private $userId;

    /**
     * @var \DateTime
     * @ODM\Date(nullable=false)
     */
    private $calculated;

    /**
     * @var float
     * @ODM\Float(nullable=false)
     */
    private $calculatedInMs;

    /**
     * @var int
     * @ODM\Int(nullable=false)
     */
    private $position;

    /**
     * @var int
     * @ODM\Int(nullable=false)
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