<?php

namespace OverwatchBundle\DTO;

class UserScoreCollection {

    /**
     * @var UserScoreDto[]
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
     * @return UserScoreDto[]
     */
    public function getScores() {
        return $this->scores;
    }

    /**
     * @param UserScoreDto $score
     */
    public function addScore(UserScoreDto $score) {
        if (!is_array($this->scores)) {
            $this->scores = [];
        }

        $this->scores[] = $score;
        $this->totalScores = count($this->scores);
    }

    /**
     * @param UserScoreDto[] $scores
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
    public function getHasMore() {
        return $this->hasMore;
    }

    /**
     * @param boolean $hasMore
     */
    public function setHasMore($hasMore = true) {
        $this->hasMore = $hasMore;
    }
}