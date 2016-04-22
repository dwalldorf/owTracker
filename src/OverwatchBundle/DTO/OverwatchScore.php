<?php

namespace OverwatchBundle\DTO;

class OverwatchScore {

    /**
     * @var string
     */
    private $userName;

    /**
     * @var int
     */
    private $verdicts;

    /**
     * @param string $userName
     * @param int $verdicts
     */
    public function __construct($userName, $verdicts = 0) {
        $this->userName = $userName;
        $this->verdicts = $verdicts;
    }
}