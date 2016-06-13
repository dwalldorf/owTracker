<?php

namespace AppBundle\Model;

class CacheKey {

    private $format;

    private $args;

    public function __construct() {
        $this->args = func_get_args();
        $this->format = array_shift($this->args);
    }

    /**
     * @return string
     */
    public function getFormat() {
        return $this->format;
    }

    /**
     * @return array
     */
    public function getArgs() {
        return $this->args;
    }

    public function toString() {
        return vsprintf($this->format, $this->args);
    }
}