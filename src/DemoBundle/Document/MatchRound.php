<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MatchRound {

    /**
     * @var int
     * @ODM\Int(name="round", nullable=false)
     */
    private $roundNumber;

    /**
     * @var float
     * @ODM\Float(name="duration")
     */
    private $roundDuration;

    /**
     * @var RoundEvents
     * @ODM\EmbedOne(name="events", targetDocument="RoundEvents")
     */
    private $roundEvents;

    /**
     * @param int $roundNumber
     * @param RoundEvents $roundEvents
     */
    public function __construct($roundNumber = null, $roundDuration = null, $roundEvents = null) {
        $this->roundNumber = $roundNumber;
        $this->roundDuration = $roundDuration;
        $this->roundEvents = $roundEvents;
    }

    /**
     * @return int
     */
    public function getRoundNumber() {
        return $this->roundNumber;
    }

    /**
     * @param int $roundNumber
     */
    public function setRoundNumber($roundNumber) {
        $this->roundNumber = $roundNumber;
    }
}