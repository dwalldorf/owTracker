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
        $exception = $event->getException();

        if ($exception instanceof ApiBaseException) {
            $response = new Response();

            $httpStatus = $exception->getHttpStatusCode();
            $content = [];

            if ($exception->getMessage()) {
                $content ['reason'] = $exception->getMessage();
            }
            if ($exception->getErrors()) {
                $content['errors'] = $exception->getErrors();
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