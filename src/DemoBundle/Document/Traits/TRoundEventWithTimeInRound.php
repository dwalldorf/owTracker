<?php

namespace DemoBundle\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait TRoundEventWithTimeInRound {

    /**
     * @var int
     * @ODM\Field(type="int", name="time_in_round")
     * @ODM\Index
     */
    private $timeInRound;

    /**
     * @return int
     */
    public function getTimeInRound() {
        return $this->timeInRound;
    }

    /**
     * @param int $timeInRound
     */
    public function setTimeInRound($timeInRound) {
        $this->timeInRound = $timeInRound;
    }
}