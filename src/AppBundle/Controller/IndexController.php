<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class IndexController extends BaseController {

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        $user = new User();
        $this->getService(UserService::SERVICE_NAME)->register($user);
        return $this->render('index');
    }
}
