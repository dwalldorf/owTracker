<?php

namespace AppBundle\Util;

class StopWatch {

    private $start;

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

    public function getRuntime() {
        return $this->elapsedSeconds;
    }

    public function getRuntimeStringInMs() {
        return sprintf('%f ms', $this->elapsedMs);
    }

    public function getRuntimeStringInS() {
        return sprintf('%fs', $this->elapsedMs);
    }
}