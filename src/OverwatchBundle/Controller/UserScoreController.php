<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\NotFoundException;
use OverwatchBundle\Service\UserScoreService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotLoggedInException;

class UserScoreController extends BaseController {

    /**
     * @var UserScoreService
     */
    private $userScoreService;

    protected function init() {
        $this->userScoreService = $this->getService(UserScoreService::ID);
    }

    /**
     * @Route("/api/overwatch/scores/{userId}")
     * @Method({"GET"})
     *
     * @param string $userId
     * @return Response
     *
     * @throws NotFoundException
     * @throws NotLoggedInException
     */
    public function getByUserAction($userId) {
        $this->requireLogin();

        $period = $this->getRequestParamAsInt('period', -1);
        $userScore = $this->userScoreService->getByUserId($userId, $period);

        if (!$userScore) {
            throw new NotFoundException();
        }

        $retVal = $this->userScoreService->toDto($userScore);
        return $this->json($retVal);
    }

    /**
     * @Route(
     *     "/api/overwatch/scores/higher/{userId}/{period}",
     *     requirements={"period" = "\d+"}
     * )
     * @Method("GET")
     *
     * @param string $userId
     * @param int $period
     * @return Response
     *
     * @throws NotLoggedInException
     */
    public function getHigherThanUserAction($userId, $period = 30) {
        $this->requireLogin();

        $period = intval($period);
        $limit = $this->getRequestParamAsInt('limit', 10, 50);
        $offset = $this->getRequestParamAsInt('offset');

        $scores = $this->userScoreService->getHigherThan($userId, $period, $limit, $offset);
        return $this->json($scores);
    }

    /**
     * @Route(
     *     "/api/overwatch/scores/lower/{userId}/{period}",
     *     requirements={"period" = "\d+"}
     * )
     * @Method("GET")
     *
     * @param string $userId
     * @param int $period
     * @return Response
     *
     * @throws NotLoggedInException
     */
    public function getLowerThanUserAction($userId, $period = 30) {
        $this->requireLogin();

        $period = intval($period);
        $limit = $this->getRequestParamAsInt('limit', 10, 50);
        $offset = $this->getRequestParamAsInt('offset');

        $scores = $this->userScoreService->getLowerThan($userId, $period, $limit, $offset);
        return $this->json($scores);
    }
}