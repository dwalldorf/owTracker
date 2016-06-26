<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

class ServerErrorException extends ApiBaseException {

    /**
     * @return int
     */
    public function getHttpStatusCode() {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}