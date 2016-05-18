<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\DTO\UserScoreDto;
use OverwatchBundle\Service\UserScoreService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @throws NotLoggedInException
     */
    public function getByUserAction($userId) {
        $this->requireLogin();

        $period = intval($this->getQueryParam('period'));
        $userScore = $this->userScoreService->getByUserId($userId, $period);

        return $this->jsonResponse($this->userScoreService->toDto($userScore));
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
     * @throws NotLoggedInException
     */
    public function getHigherThanUserAction($userId, $period = 30) {
        $this->requireLogin();

        $period = intval($period);
        $limit = $this->getLimit();
        $offset = $this->getOffset();

        $scores = $this->userScoreService->getHigherThan($userId, $period, $limit, $offset);
        return $this->jsonResponse($scores);
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
     * @throws NotLoggedInException
     */
    public function getLowerThanUserAction($userId, $period = 30) {
        $this->requireLogin();

        $period = intval($period);
        $limit = $this->getLimit();
        $offset = $this->getOffset();

        $scores = $this->userScoreService->getLowerThan($userId, $period, $limit, $offset);
        return $this->jsonResponse($scores);
    }

    private function getOffset() {
        return intval($this->getQueryParam('offset', 0));
    }

    /**
     * @return int
     */
    private function getLimit() {
        $limit = intval($this->getQueryParam('limit', 10));

        if ($limit > 50) {
            $limit = 50;
        }

        return $limit;
    }
}