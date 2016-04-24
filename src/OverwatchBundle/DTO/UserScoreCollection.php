<?php

namespace OverwatchBundle\DTO;

use OverwatchBundle\Document\UserScore;

class UserScoreCollection {

    /**
     * @var UserScore[]
     */
    private $scores = [];

    /**
     * @var int
     */
    private $totalScores = 0;

    /**
     * @var bool
     */
    private $hasMore = false;

    /**
     * @return UserScore[]
     */
    public function getScores() {
        return $this->scores;
    }

    /**
     * @param UserScore $score
     */
    public function addScore(UserScore $score) {
        if (!is_array($this->scores)) {
            $this->scores = [];
        }

        $this->scores[] = $score;
        $this->totalScores = count($this->scores);
    }

    /**
     * @param UserScore[] $scores
     */
    public function setScores($scores) {
        $this->scores = $scores;
        $this->totalScores = count($this->scores);
    }

    /**
     * @return int
     */
    public function getTotalScores() {
        return $this->totalScores;
    }

    /**
     * @return boolean
     */
    public function hasMore() {
        return $this->hasMore;
    }

    /**
     * @param boolean $hasMore
     */
    public function setHasMore($hasMore = true) {
        $this->hasMore = $hasMore;
    }
}