<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class RoundEventKill {

    /**
     * @var string
     * @ODM\String(nullable=false)
     */
    private $killer;

    /**
     * @var string
     * @ODM\String(nullable=false)
     */
    private $killed;

    /**
     * @var float
     * @ODM\Float(name="time")
     */
    private $itmeInRound;

    /**
     * @var bool
     * @ODM\Boolean(nullable=false)
     */
    private $headshot;

    /**
     * @param string $killerSteamId
     * @param string $killedSteamId
     * @param bool $headshot
     */
    public function __construct($killerSteamId = null, $killedSteamId = null, $headshot = false) {
        /*
         * TODO: add timeInRound
         * by dwalldorf at 23:44 20.06.16
         */

        $this->killer = $killerSteamId;
        $this->killed = $killedSteamId;
        $this->headshot = $headshot;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'kill';
    }

    /**
     * @return string
     */
    public function getKiller() {
        return $this->killer;
    }

    /**
     * @param string $killer
     */
    public function setKiller($killer) {
        $this->killer = $killer;
    }

    /**
     * @return string
     */
    public function getKilled() {
        return $this->killed;
    }

    /**
     * @param string $killed
     */
    public function setKilled($killed) {
        $this->killed = $killed;
    }

    /**
     * @return boolean
     */
    public function isHeadshot() {
        return $this->headshot;
    }

    /**
     * @param boolean $headshot
     */
    public function setHeadshot($headshot) {
        $this->headshot = $headshot;
    }
}