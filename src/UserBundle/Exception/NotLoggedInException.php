<?php

namespace UserBundle\Exception;

use AppBundle\Exception\ApiBaseException;

class NotLoggedInException extends ApiBaseException {

    public function __construct(array $errors, $message, $code, \Exception $previous) {
        parent::__construct($errors, $message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatusCode() {
        return 403;
    }
}