<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DemoInfoController extends BaseController {

    /**
     * @Route("/api/demos")
     * @Method("POST")
     * @return Response
     */
    public function postAction() {
        // for reference: https://jsfiddle.net/entek/37x25f13/
        $apiToken = $this->container->getParameter('demo_api_token');

        return $this->json($apiToken);
    }
}