<?php

namespace UserBundle\Exception;

use AppBundle\Exception\ApiBaseException;

class RegisterUserException extends ApiBaseException {

    public function getHttpStatusCode() {
        return 400;
    }
}