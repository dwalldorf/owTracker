<?php

namespace UserBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\BadRequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Document\User;
use UserBundle\Exception\RegisterUserException;
use UserBundle\Service\UserService;

class UserController extends BaseController {

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
        $this->userService = $this->getService(UserService::ID);
    }

    /**
     * @Route("/api/users/me")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meAction(Request $request) {
        $user = $this->getCurrentUser();

        return $this->jsonResponse($user);
    }

    /**
     * @Route("/api/user/login")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws BadRequestException
     */
    public function loginAction(Request $request) {
        /* @var $user User */
        $user = $this->getEntityFromRequest($request, User::class);
        $dbUser = $this->userService->login($user);

        if ($dbUser->getId()) {
            return $this->jsonResponse($dbUser);
        }
        throw new BadRequestException('invalid credentials');
    }

    /**
     * @Route("/api/users")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws RegisterUserException
     *
     * @internal $user User
     */
    public function registerAction(Request $request) {
        /* @var $user User */
        $user = $this->getEntityFromRequest($request, User::class);
        $userId = $this->userService->register($user);

        if ($userId) {
            return $this->jsonResponse($userId, 201);
        }

        return $this->jsonResponse(null, 400);
    }

    /**
     * @Route("/api/users")
     * @Method({"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllAction(Request $request) {
        return $this->jsonResponse($this->userService->getAllUsers());
    }
}