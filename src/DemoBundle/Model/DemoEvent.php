<?php

namespace DemoBundle\Model;

class DemoEvent {

    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $timeInRound;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return int
     */
    public function getEventId() {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     * @return $this
     */
    public function setEventId($eventId) {
        $this->eventId = $eventId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeInRound() {
        return $this->timeInRound;
    }

    /**
     * @param int $timeInRound
     * @return $this
     */
    public function setTimeInRound($timeInRound) {
        $this->timeInRound = $timeInRound;
        return $this;
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
}