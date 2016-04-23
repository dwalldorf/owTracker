<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\InvalidArgumentException;
use OverwatchBundle\Document\Verdict;
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
     * @Route("/api/overwatch/verdicts/{userId}")
     * @Method({"GET"})
     *
     * @param string $userId
     * @return Response
     * @throws NotLoggedInException
     */
    public function getByUserAction($userId) {
        $this->requireLogin();

        $verdicts = $this->overwatchService->getByUserId($userId);
        return $this->jsonResponse($verdicts);
    }

    /**
     * @Route("/api/overwatch/mappool")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function getMapPoolAction() {
        return $this->jsonResponse($this->overwatchService->getMapPool());
    }

    /**
     * @Route("/api/overwatch/verdicts")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response
     *
     * @throws InvalidArgumentException
     * @throws NotLoggedInException
     */
    public function submitAction(Request $request) {
        $this->requireLogin();

        /* @var $verdict Verdict */
        $verdict = $this->getEntityFromRequest($request, Verdict::class);
        $verdict->setUserId($this->getCurrentUser()->getId());

        $dbVerdict = $this->overwatchService->save($verdict);

        if ($dbVerdict->getId()) {
            return $this->jsonResponse($dbVerdict, Response::HTTP_CREATED);
        }
        return $this->jsonResponse('handle this', 400);
    }
}