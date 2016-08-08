<?php

namespace DemoBundle\Document;

use DemoBundle\Document\Traits\TRoundEventWithTimeInRound;
use DemoBundle\Document\Traits\TRoundEventWithUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class RoundEventBombDefused {

    use TRoundEventWithUser;
    use TRoundEventWithTimeInRound;

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
     * @return mixed
     */
    public function getTimeLeft() {
        return $this->timeLeft;
    }

    /**
     * @param mixed $timeLeft
     * @return $this
     */
    public function setTimeLeft($timeLeft) {
        $this->timeLeft = $timeLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWithDefuseKit() {
        return $this->withDefuseKit;
    }

    /**
     * @param mixed $withDefuseKit
     * @return $this
     */
    public function setWithDefuseKit($withDefuseKit) {
        $this->withDefuseKit = $withDefuseKit;
        return $this;
    }
}