<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use DemoBundle\Service\DemoService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotLoggedInException;

class DemoController extends BaseController {

    /**
     * @var DemoService
     */
    private $demoService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
    }

    /**
     * @Route("/api/matches")
     * @Method("GET")
     * @return Response
     *
     * @throws NotLoggedInException
     */
    public function getAllAction() {
        $this->requireLogin();

        $limit = $this->getRequestParamAsInt('limit', 20);
        $offset = $this->getRequestParamAsInt('offset', 0);

        $res = $this->demoService->getByUser($this->getCurrentUser(), $limit, $offset);
        return $this->json($res);
    }
}