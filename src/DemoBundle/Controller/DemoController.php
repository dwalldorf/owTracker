<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\ServerErrorException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotAuthorizedException;

class DemoController extends BaseController {

    /**
     * @Route("/api/demos")
     * @Method("POST")
     * @return Response
     *
     * @throws ServerErrorException
     * @throws NotAuthorizedException
     */
    public function postAction() {
        // for reference: https://jsfiddle.net/entek/37x25f13/
        $apiToken = $this->container->getParameter('demo_api_token');
        $apiToken = $this->validateApiToken($apiToken);

        if ($apiToken) {
            return $this->json($apiToken);
        }
    }
}