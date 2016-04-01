<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidArgumentException extends ApiBaseException {

    /**
     * @return int
     */
    public function getHttpStatusCode() {
        return Response::HTTP_BAD_REQUEST;
    }
}