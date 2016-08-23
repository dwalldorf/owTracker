<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use DemoBundle\Document\Traits\TRoundEventWithTimeInRound;
use DemoBundle\Document\Traits\TRoundEventWithUser;

class RoundEventBeginDefuse extends RoundEvent {

    use TRoundEventWithUser;
    use TRoundEventWithTimeInRound;

    /**
     * @var bool
     * @ODM\Field(type="bool", name="has_kit")
     */
    private $hasKit;

    /**
     * @return boolean
     */
    public function isHasKit() {
        return $this->hasKit;
    }

    /**
     * @param boolean $hasKit
     */
    public function setHasKit($hasKit) {
        $this->hasKit = $hasKit;
    }
}