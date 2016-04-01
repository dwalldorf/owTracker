<?php

namespace UserBundle\Exception;

use AppBundle\Exception\ApiBaseException;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserException extends ApiBaseException {

    public function getHttpStatusCode() {
        return Response::HTTP_BAD_REQUEST;
    }
}