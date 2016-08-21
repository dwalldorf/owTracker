<?php

namespace DemoBundle\Document;

use Doctrine\ODM\Couchdb\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MatchRound {

    /**
     * @var int
     * @ODM\Field(type="int", name="round", nullable=false)
     */
    private $roundNumber;

    /**
     * @var float
     * @ODM\Field(type="float", name="duration")
     */
    private $duration;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $winner;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $reason;

    /**
     * @var array
     * @ODM\Field(type="hash", name="events")
     */
    private $events;

    /**
     * @return int
     */
    public function getRoundNumber() {
        return $this->roundNumber;
    }

    /**
     * @param int $roundNumber
     * @return $this
     */
    public function setRoundNumber($roundNumber) {
        $this->roundNumber = $roundNumber;
        return $this;
    }

    /**
     * @param int $nr
     * @return $this
     */
    public function setNr($nr) {
        $this->setRoundNumber($nr);
        return $this;
    }

    /**
     * @return float
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param float $duration
     * @return $this
     */
    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return int
     */
    public function getWinner() {
        return $this->winner;
    }

    /**
     * @param int $winner
     * @return $this
     */
    public function setWinner($winner) {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return int
     */
    public function getReason() {
        return $this->reason;
    }

    /**
     * @param int $reason
     * @return $this
     */
    public function setReason($reason) {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return array
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * @param array $events
     * @return $this
     */
    public function setEvents($events) {
        $this->events = $events;
        return $this;
    }
}