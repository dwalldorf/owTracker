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
        $this->userService = $this->getService(UserService::SERVICE_NAME);
    }

    /**
     * @Route("/api/user")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @internal $user User
     */
    public function registerAction(Request $request) {
//        /* @var $user User */
        $user = $this->getEntityFromRequest($request, User::class);
        $this->userService->register($user);

        return $this->jsonResponse(null);
    }
}