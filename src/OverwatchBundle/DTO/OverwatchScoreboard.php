<?php

namespace OverwatchBundle\DTO;

use OverwatchBundle\Document\OverwatchUserScore;

class OverwatchScoreboard {

    /**
     * @var int
     */
    private $period;

    /**
     * @var OverwatchUserScore[]
     */
    private $top10 = [];

    /**
     * @var OverwatchUserScore
     */
    private $userScore;

    /**
     * @var OverwatchUserScore[]
     */
    private $next10;

    /**
     * @param $period
     * @param OverwatchUserScore[] $top10
     * @param OverwatchUserScore $userScore
     * @param OverwatchUserScore[] $next10
     */
    public function __construct($period, array $top10, OverwatchUserScore $userScore, array $next10) {
        $this->period = $period;
        $this->top10 = $top10;
        $this->userScore = $userScore;
        $this->next10 = $next10;
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
     * @return \OverwatchBundle\Document\OverwatchUserScore[]
     */
    public function getTop10() {
        return $this->top10;
    }

    /**
     * @return OverwatchUserScore
     */
    public function getUserScore() {
        return $this->userScore;
    }

    /**
     * @return \OverwatchBundle\Document\OverwatchUserScore[]
     */
    public function getNext10() {
        return $this->next10;
    }
}