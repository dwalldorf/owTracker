<?php

namespace OverwatchBundle\DTO;

use OverwatchBundle\Document\OverwatchUserScore;

class OverwatchScoreboard {

    /**
     * @var int
     */
    private $period;

    /**
     * @var OverwatchScore[]
     */
    private $top10 = [];

    /**
     * @var OverwatchScore
     */
    private $userScore;

    /**
     * @var OverwatchScore[]
     */
    private $next10;

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
     * @return OverwatchScore[]
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
     * @return OverwatchScore[]
     */
    public function getNext10() {
        return $this->next10;
    }
}