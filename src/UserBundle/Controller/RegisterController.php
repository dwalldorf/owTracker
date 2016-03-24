<?php

namespace UserBundle\Controller;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends BaseController {

    /**
     * @Route("/api/user")
     * @Method({"POST"})
     * @param Request $request
     */
    public function createAction(Request $request) {
        var_dump($request->getContent());
    }
}