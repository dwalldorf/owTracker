<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends BaseController {

    /**
     * @Route("/")
     */
    public function indexAction(Request $request) {
        return $this->render('index');
    }
}
