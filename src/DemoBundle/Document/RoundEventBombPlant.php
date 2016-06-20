<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class RoundEventBombPlant {

    /**
     * @var string
     * @ODM\String
     */
    private $player;

    /**
     * @var float
     * @ODM\Float(name="time")
     */
    private $timeInRound;

    /**
     * @param string $playerSteamId
     * @param float $timeInRound
     */
    public function __construct($playerSteamId = null, $timeInRound = null) {
        $this->player = $playerSteamId;
        $this->timeInRound = $timeInRound;
    }

    /**
     * @return string
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * @param string $player
     */
    public function setPlayer($player) {
        $this->player = $player;
    }

    /**
     * @return float
     */
    public function getTimeInRound() {
        return $this->timeInRound;
    }

    /**
     * @param float $timeInRound
     */
    public function setTimeInRound($timeInRound) {
        $this->timeInRound = $timeInRound;
    }
}