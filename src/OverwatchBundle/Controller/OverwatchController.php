<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\InvalidArgumentException;
use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Service\OverwatchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotLoggedInException;

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
     * @throws NotLoggedInException
     */
    public function getAction() {
        $this->requireLogin();

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
     * @throws NotLoggedInException
     */
    public function submitAction(Request $request) {
        $this->requireLogin();

        $user = $this->getCurrentUser();

        /* @var $overwatch Overwatch */
        $overwatch = $this->getEntityFromRequest($request, Overwatch::class);
        if (!$overwatch->hasValidMap()) {
            throw new InvalidArgumentException('invalid map');
        }

        $overwatch->setUserId($user->getId());

        $overwatch = $this->overwatchService->save($overwatch);

        if ($overwatch->getId()) {
            return $this->jsonResponse($overwatch, 201);
        }
        return $this->jsonResponse('handle this', 400);
    }
}