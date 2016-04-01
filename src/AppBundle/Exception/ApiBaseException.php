<?php

namespace AppBundle\Exception;

abstract class ApiBaseException extends \Exception {

    /**
     * @var array
     */
    private $errors;

    public function __construct($message = '', array $errors = [], $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return int
     */
    public abstract function getHttpStatusCode();

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}