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
            $response = new Response();

            $httpStatus = $ex->getHttpStatusCode();
            $content = [];

            if ($ex->getMessage()) {
                $content ['reason'] = $ex->getMessage();
            }
            if ($ex->getErrors()) {
                $content['errors'] = $ex->getErrors();
            }

            if (count($content) > 0) {
                $response->setContent(AppSerializer::getInstance()->toJson($content));
            }

            $response->setStatusCode($httpStatus);
            $response->headers->set('Content-Type', 'application/json');
            $event->setResponse($response);
        }
    }
}