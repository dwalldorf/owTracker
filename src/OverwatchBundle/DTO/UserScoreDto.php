<?php

namespace OverwatchBundle\DTO;

class UserScoreDto {

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $score;

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getScore() {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore($score) {
        $this->score = $score;
    }
}