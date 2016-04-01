<?php

namespace UserBundle\Exception;

use AppBundle\Exception\ApiBaseException;

class NotLoggedInException extends ApiBaseException {

    /**
     * @return int
     */
    public function getHttpStatusCode() {
        return 403;
    }
}