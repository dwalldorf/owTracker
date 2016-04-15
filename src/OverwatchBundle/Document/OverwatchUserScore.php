<?php

namespace OverwatchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Int;
use Doctrine\ODM\MongoDB\Mapping\Annotations\String;

/**
 * @Document(collection="overwatch_stats", db="user_scores", repositoryClass="OverwatchBundle\Repository\OverwatchUserScoreRepository")
 */
class OverwatchUserScore {

    const DAILY_PERIOD = 1;

    const WEEKLY_PERIOD = 7;

    const MONTHLY_PERIOD = 30;

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