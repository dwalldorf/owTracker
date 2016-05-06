<?php

namespace OverwatchBundle\Document;

class Demo {

    private $demoProtocol;

    private $networkProtocol;

    private $hostName;

    private $clientName;

    private $mapName;

    private $gameDir;

    private $time;

    private $ticks;

    private $frames;

    private $tickRate;

    private $type;

    private $statusPresent = false;

    /**
     * @return mixed
     */
    public function getDemoProtocol() {
        return $this->demoProtocol;
    }

    /**
     * @param mixed $demoProtocol
     */
    public function setDemoProtocol($demoProtocol) {
        $this->demoProtocol = $demoProtocol;
    }

    /**
     * @return mixed
     */
    public function getNetworkProtocol() {
        return $this->networkProtocol;
    }

    /**
     * @param mixed $networkProtocol
     */
    public function setNetworkProtocol($networkProtocol) {
        $this->networkProtocol = $networkProtocol;
    }

    /**
     * @return mixed
     */
    public function getHostName() {
        return $this->hostName;
    }

    /**
     * @param mixed $hostName
     */
    public function setHostName($hostName) {
        $this->hostName = $hostName;
    }

    /**
     * @return mixed
     */
    public function getClientName() {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     */
    public function setClientName($clientName) {
        $this->clientName = $clientName;
    }

    /**
     * @return mixed
     */
    public function getMapName() {
        return $this->mapName;
    }

    /**
     * @param mixed $mapName
     */
    public function setMapName($mapName) {
        $this->mapName = $mapName;
    }

    /**
     * @return mixed
     */
    public function getGameDir() {
        return $this->gameDir;
    }

    /**
     * @param mixed $gameDir
     */
    public function setGameDir($gameDir) {
        $this->gameDir = $gameDir;
    }

    /**
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time) {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getTicks() {
        return $this->ticks;
    }

    /**
     * @param mixed $ticks
     */
    public function setTicks($ticks) {
        $this->ticks = $ticks;
    }

    /**
     * @return mixed
     */
    public function getFrames() {
        return $this->frames;
    }

    /**
     * @param mixed $frames
     */
    public function setFrames($frames) {
        $this->frames = $frames;
    }

    /**
     * @return mixed
     */
    public function getTickRate() {
        return $this->tickRate;
    }

    /**
     * @param mixed $tickRate
     */
    public function setTickRate($tickRate) {
        $this->tickRate = $tickRate;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStatusPresent() {
        return $this->statusPresent;
    }

    /**
     * @param mixed $statusPresent
     */
    public function setStatusPresent($statusPresent) {
        $this->statusPresent = $statusPresent;
    }
}