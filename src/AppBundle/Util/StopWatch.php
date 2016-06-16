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
    private $elapsedMs = 0.0;

    public function start() {
        $this->start = microtime(true);
    }

    public function stop() {
        $this->end = microtime(true);
        $this->elapsedMs = ($this->end - $this->start) * 1000;
    }

    /**
     * @return float
     */
    public function getRuntimeInMs() {
        return $this->elapsedMs;
    }

    /**
     * @return float
     */
    public function getRuntimeInS() {
        return $this->elapsedMs / 1000;
    }

    public function setRuntime($ms) {
        $this->elapsedMs = $ms;
    }

    /**
     * @return string
     */
    public function getRuntimeStringInMs() {
        $runtime = NumberUtil::thousandsSeparator($this->elapsedMs, 3, '.', '');
        return $runtime . ' ms';
    }

    /**
     * @return string
     */
    public function getRuntimeStringInS() {
        $runtime = NumberUtil::thousandsSeparator($this->elapsedMs / 1000, 3, '.');
        return $runtime . 's';
    }
}