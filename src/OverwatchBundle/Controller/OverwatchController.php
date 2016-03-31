<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Service\OverwatchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OverwatchController extends BaseController {

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    protected function init() {
        $this->overwatchService = $this->getService(OverwatchService::ID);
    }

    /**
     * @Route("/api/overwatch")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function getAction() {
        $user = $this->getCurrentUser();
        $overwatchCases = $this->overwatchService->getByUser($user);
        return $this->jsonResponse($overwatchCases);
    }

    /**
     * @Route("/api/overwatch")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function submitAction(Request $request) {
        /* @var $overwatch Overwatch */
        $overwatch = $this->getEntityFromRequest($request, Overwatch::class);
        $user = $this->getCurrentUser();

        $overwatch->setUserId($user->getId());
        $overwatch = $this->overwatchService->save($overwatch);

        if ($overwatch->getId()) {
            return $this->jsonResponse($overwatch, 201);
        }
        return $this->jsonResponse('handle this', 400);
    }
}