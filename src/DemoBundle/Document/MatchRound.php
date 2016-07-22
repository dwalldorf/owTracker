<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\EmbeddedDocument
 */
class MatchRound {

    /**
     * @var int
     * @ODM\Field(type="int", name="round", nullable=false)
     *
     * @Assert\NotBlank(message="roundNumber for round is mandatory")
     */
    private $roundNumber;

    /**
     * @var float
     * @ODM\Field(type="float", name="duration")
     *
     * @Assert\NotBlank(message="roundDuration for round is mandatory")
     */
    private $roundDuration;

    /**
     * @var RoundEvents
     * @ODM\EmbedOne(name="events", targetDocument="RoundEvents")
     */
    private $roundEvents;

    /**
     * @param int $roundNumber
     * @param float $roundDuration
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

    /**
     * @return float
     */
    public function getRoundDuration() {
        return $this->roundDuration;
    }

    /**
     * @param float $roundDuration
     */
    public function setRoundDuration($roundDuration) {
        $this->roundDuration = $roundDuration;
    }

    /**
     * @return RoundEvents
     */
    public function getRoundEvents() {
        return $this->roundEvents;
    }

    /**
     * @param RoundEvents $roundEvents
     */
    public function setRoundEvents($roundEvents) {
        $this->roundEvents = $roundEvents;
    }
}