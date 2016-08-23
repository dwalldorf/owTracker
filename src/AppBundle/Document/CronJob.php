<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="cronjobs",
 *     repositoryClass="AppBundle\Repository\CronJobRepository"
 * )
 */
class CronJob {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     * @ODM\Index(unique=true)
     */
    private $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $command;

    /**
     * @var array
     * @ODM\Field(type="hash")
     */
    private $arguments = [];

    /**
     * @var array
     * @ODM\Field(type="hash")
     */
    private $options = [];

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $interval;

    /**
     * @var bool
     * @ODM\Field(type="boolean")
     */
    private $running = false;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $started = 0;

    /**
     * @var int
     * @ODM\Field(type="int", name="last_run")
     */
    private $lastRun = 0;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return string
     */
    public function getCommand() {
        return $this->command;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function setArguments($arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterval() {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return $this
     */
    public function setInterval($interval) {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRunning() {
        return $this->running;
    }

    /**
     * @param boolean $running
     * @return $this
     */
    public function setRunning($running = true) {
        $this->running = $running;
        return $this;
    }

    /**
     * @return int
     */
    public function getStarted() {
        return $this->started;
    }

    /**
     * @param int $started
     */
    public function setStarted($started) {
        $this->started = $started;
    }

    /**
     * @return int
     */
    public function getLastRun() {
        return $this->lastRun;
    }

    /**
     * @param int $lastRun
     * @return $this
     */
    public function setLastRun($lastRun) {
        $this->lastRun = $lastRun;
        return $this;
    }
}