<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends ApiBaseException{

    /**
     * @return int
     */
    public function getHttpStatusCode() {
        return Response::HTTP_NOT_FOUND;
    }
}