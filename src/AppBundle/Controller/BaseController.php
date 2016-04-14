<?php

namespace AppBundle\Controller;

use AppBundle\Service\IGetService;
use AppBundle\Util\AppSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Document\User;
use UserBundle\Exception\NotLoggedInException;
use UserBundle\Service\UserService;

abstract class BaseController extends Controller implements IGetService {

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var UserService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);

        $this->session = $this->container->get('session');
        $this->session->start();

        $this->userService = $this->getService(UserService::ID);

        $this->init();
    }

    protected function init() {
    }

    /**
     * @param string $templateName
     * @param array $params
     * @param Response $response
     * @return Response
     */
    protected function render($templateName, array $params = [], Response $response = null) {
        $templateName .= '.html.twig';
        $params['base_dir'] = $this->getBaseDir();

        return parent::render($templateName, $params, $response);
    }

    /**
     * @param $content
     * @param int $status
     * @return Response
     */
    protected final function response($content, $status = 200) {
        return new Response($content, $status);
    }

    /**
     * @param $content
     * @param int $status
     * @return Response
     */
    protected final function jsonResponse($content, $status = 200) {
        $jsonContent = AppSerializer::getInstance()->toJson($content);

        $response = new Response($jsonContent, $status);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @param $targetEntity
     * @return object
     */
    protected function getEntityFromRequest(Request $request, $targetEntity) {
        return AppSerializer::getInstance()->fromJson($request->getContent(), $targetEntity);
    }

    public function getService($serviceId) {
        return $this->container->get($serviceId);
    }

    /**
     * @return bool
     */
    protected final function isLoggedIn() {
        return $this->session->get('user') != null;
    }

    /**
     * @throws NotLoggedInException
     */
    protected final function requireLogin() {
        if (!$this->isLoggedIn()) {
            throw new NotLoggedInException();
        }
    }

    /**
     * @return User|null
     */
    protected final function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return $this->session->get('user');
    }

    /**
     * @return string
     */
    private function getBaseDir() {
        return realpath(dirname(__DIR__) . '/../../');
    }
}