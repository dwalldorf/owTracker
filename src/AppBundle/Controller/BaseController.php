<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller {

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
     * @return string
     */
    protected function getBaseDir() {
        return realpath(dirname(__DIR__) . '/../../');
    }
}