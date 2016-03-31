<?php

namespace AppBundle\Exception;

use AppBundle\Util\AppSerializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ApiExceptionListener {

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $ex = $event->getException();

        if ($ex instanceof ApiBaseException) {
            $content = AppSerializer::getInstance()->toJson($ex->getErrors());
            $httpStatus = $ex->getHttpStatusCode();

            $response = new Response($content, $httpStatus);
            $event->setResponse($response);
        }
    }
}