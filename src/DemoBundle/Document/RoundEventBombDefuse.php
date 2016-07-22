<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class RoundEventBombDefuse {

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $player;

    /**
     * @var float
     * @ODM\Field(type="float", name="time")
     */
    private $timeInRound;

    /**
     * @var float
     * @ODM\Field(type="float", name="time_left")
     */
    private $timeLeft;

    /**
     * @var bool
     * @ODM\Field(type="boolean", name="defuser")
     */
    private $withDefuseKit;

    /**
     * @param string $playerSteamId
     * @param float $timeInRound
     * @param float $timeLeft
     * @param bool $withDefuseKit
     */
    public function __construct($playerSteamId = null, $timeInRound = null, $timeLeft = null, $withDefuseKit = null) {
        $this->player = $playerSteamId;
        $this->timeInRound = $timeInRound;
        $this->timeLeft = $timeLeft;
        $this->withDefuseKit = $withDefuseKit;
    }

    /**
     * @return mixed
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player) {
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getTimeInRound() {
        return $this->timeInRound;
    }

    /**
     * @param mixed $timeInRound
     */
    public function setTimeInRound($timeInRound) {
        $this->timeInRound = $timeInRound;
    }

    /**
     * @return mixed
     */
    public function getTimeLeft() {
        return $this->timeLeft;
    }

    /**
     * @param mixed $timeLeft
     */
    public function setTimeLeft($timeLeft) {
        $this->timeLeft = $timeLeft;
    }

    /**
     * @return mixed
     */
    public function getWithDefuseKit() {
        return $this->withDefuseKit;
    }

    /**
     * @param mixed $withDefuseKit
     */
    public function setWithDefuseKit($withDefuseKit) {
        $this->withDefuseKit = $withDefuseKit;
    }
}