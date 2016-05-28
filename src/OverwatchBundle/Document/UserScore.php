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
     * @ODM\Id
     * @var string
     */
    private $id;

    /**
     * @ODM\Int(nullable=false)
     * @ODM\Index(order="asc")
     * @var int
     */
    private $period;

    /**
     * @ODM\String(name="user_id", nullable=false)
     * @var string
     */
    private $userId;

    /**
     * @ODM\Date(nullable=false)
     * @var \DateTime
     */
    private $calculated;

    /**
     * @ODM\Float(nullable=false)
     * @var float
     */
    private $calculatedInMs;

    /**
     * @ODM\Int(nullable=false)
     * @ODM\Index(order="desc")
     * @var int
     */
    private $position;

    /**
     * @ODM\Int(nullable=false)
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