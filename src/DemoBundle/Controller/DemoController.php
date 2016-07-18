<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\DTO\BaseCollection;
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
     * @Route("/api/demos/user/{userId}")
     * @Method("GET")
     *
     * @param string $userId
     * @return Response
     * @throws NotLoggedInException
     */
    public function getAllAction($userId) {
        $this->requireLogin();

        $limit = $this->getRequestParamAsInt('limit', 20);
        $offset = $this->getRequestParamAsInt('offset', 0);
        $demos = $this->demoService->getByUser($userId, $limit + 1, $offset);

        $demoCollection = new BaseCollection();
        $demoCollection->setItems($demos, $limit);

        return $this->json($demoCollection);
    }

    /**
     * @Route("/api/demos/{id}")
     * @Method("GET")
     *
     * @param string $id
     * @return Response
     * @throws NotLoggedInException
     */
    public function getByIdAction($id) {
        $this->requireLogin();

        $demo = $this->demoService->getById($id);
        return $this->json($demo);
    }
}