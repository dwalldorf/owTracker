<?php

namespace AppBundle\Controller;

use AppBundle\Util\AppSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller {

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);

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
    private function response($content, $status = 200) {
        return new Response($content, $status);
    }

    /**
     * @param $content
     * @param int $status
     * @return Response
     */
    private function jsonResponse($content, $status = 200) {
        $jsonContent = AppSerializer::getInstance()->toJson($content);
        return $this->response($jsonContent, $status);
    }

    /**
     * @param Request $request
     * @param $targetEntity
     * @return object
     */
    protected function getEntityFromRequest(Request $request, $targetEntity) {
        return AppSerializer::getInstance()->fromJson($request->getContent(), $targetEntity);
    }

    /**
     * @return string
     */
    protected function getBaseDir() {
        return realpath(dirname(__DIR__) . '/../../');
    }
}