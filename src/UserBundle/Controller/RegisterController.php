<?php

namespace UserBundle\Controller;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class RegisterController extends BaseController {

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
//        $this->userService =
    }

    /**
     * @Route("/api/user")
     * @Method({"POST"})
     * @param Request $request
     */
    public function registerAction(Request $request) {
        $user = $this->getEntityFromRequest($request, User::class);
    }
}