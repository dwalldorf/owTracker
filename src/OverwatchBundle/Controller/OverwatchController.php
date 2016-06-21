<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\DTO\BaseCollection;
use AppBundle\Exception\InvalidArgumentException;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Service\OverwatchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

        $retVal = new BaseCollection();
        $verdicts = $this->overwatchService->getByUserId($userId);
        $retVal->setItems($verdicts);

        return $this->json($retVal);
    }

    /**
     * @Route("/api/overwatch/mappool")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function getMapPoolAction() {
        return $this->json($this->overwatchService->getMapPool());
    }

    /**
     * @Route("/api/overwatch/verdicts")
     * @Method({"POST"})
     *
     * @return Response
     *
     * @throws InvalidArgumentException
     * @throws NotLoggedInException
     */
    public function submitAction() {
        $this->requireLogin();

        /* @var $verdict Verdict */
        $verdict = $this->getEntityFromRequest(Verdict::class);
        $verdict->setUserId($this->getCurrentUser()->getId());

        $dbVerdict = $this->overwatchService->save($verdict);

        if ($dbVerdict->getId()) {
            return $this->json($dbVerdict, Response::HTTP_CREATED);
        }
        return $this->json('handle this', Response::HTTP_BAD_REQUEST);
    }
}