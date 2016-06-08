<?php

namespace AppBundle\Util;

class StopWatch {

    /**
     * @var float
     */
    private $start;

    /**
     * @var float
     */
    private $end;

    /**
     * @var float
     */
    private $elapsedSeconds = 0.0;

    /**
     * @var float
     */
    private $elapsedMs = 0.0;

    public function start() {
        $this->start = microtime(true);
    }

    public function stop() {
        $this->end = microtime(true);

        $this->elapsedSeconds = $this->end - $this->start;
        $this->elapsedMs = $this->elapsedSeconds * 1000;
    }

    /**
     * @return float
     */
    public function getRuntime() {
        return $this->elapsedSeconds;
    }

    /**
     * @return string
     */
    public function getRuntimeStringInMs() {
        return sprintf('%f ms', $this->elapsedMs);
    }

    /**
     * @return string
     */
    public function getRuntimeStringInS() {
        return sprintf('%fs', $this->elapsedMs);
    }
}