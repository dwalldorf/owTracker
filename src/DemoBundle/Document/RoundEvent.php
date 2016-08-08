<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
abstract class RoundEvent {

    /**
     * @var int
     * @ODM\Field(type="int", name="event_id")
     */
    private $eventId;

    /**
     * @var string
     * @ODM\Field(type="string", name="event_name")
     */
    private $name;

    /**
     * @return int
     */
    public function getEventId() {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     */
    public function setEventId($eventId) {
        $this->eventId = $eventId;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $eventName
     */
    public function setName($eventName) {
        $this->name = $eventName;
    }
}