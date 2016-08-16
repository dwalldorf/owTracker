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
     * @var int
     * @ODM\Field(type="int")
     */
    private $winner;

    /**
     * @var array
     * @ODM\Field(type="hash", name="events")
     */
    private $roundEvents;

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
     * @return float
     */
    public function getRoundDuration() {
        return $this->roundDuration;
    }

    /**
     * @param float $roundDuration
     * @return $this
     */
    public function setRoundDuration($roundDuration) {
        $this->roundDuration = $roundDuration;
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
     * @return array
     */
    public function getRoundEvents() {
        return $this->roundEvents;
    }

    /**
     * @param array $roundEvents
     * @return $this
     */
    public function setRoundEvents($roundEvents) {
        $this->roundEvents = $roundEvents;
        return $this;
    }
}