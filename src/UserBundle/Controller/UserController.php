<?php

namespace UserBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\BadRequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meAction() {
        $this->requireLogin();
        return $this->jsonResponse($this->getCurrentUser());
    }

    /**
     * @Route("/api/user/login")
     * @Method({"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws BadRequestException
     */
    public function loginAction() {
        $dbUser = null;
        $loginName = $this->getFromPayload('username');
        $password = $this->getFromPayload('password');

        if ($loginName && $password) {
            $dbUser = $this->userService->login($loginName, $password);
            unset($password);
        }

        if (!$dbUser) {
            throw new BadRequestException('invalid credentials or user does not exist');
        }

        return $this->jsonResponse($dbUser);
    }

    /**
     * @Route("/api/users")
     * @Method({"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws RegisterUserException
     *
     * @internal $user User
     */
    public function registerAction() {
        /* @var $user User */
        $user = $this->getEntityFromRequest(User::class);
        $userId = $this->userService->register($user);

        if ($userId) {
            return $this->jsonResponse($userId, 201);
        }

        return $this->jsonResponse(null, 400);
    }
}