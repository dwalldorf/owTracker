<?php

namespace UserBundle\Exception;

use AppBundle\Exception\ApiBaseException;
use Symfony\Component\HttpFoundation\Response;

class NotAuthorizedException extends ApiBaseException {

    public function getHttpStatusCode() {
        return Response::HTTP_UNAUTHORIZED;
    }
}