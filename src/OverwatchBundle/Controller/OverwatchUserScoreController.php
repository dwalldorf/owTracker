<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\Service\OverwatchUserScoreService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Exception\NotLoggedInException;

class OverwatchUserScoreController extends BaseController {

    /**
     * @var OverwatchUserScoreService
     */
    private $overwatchUserScoreService;

    protected function init() {
        $this->overwatchUserScoreService = $this->getService(OverwatchUserScoreService::ID);
    }

    /**
     * @Route("/api/overwatch/userscores")
     * @Method({"GET"})
     *
     * @throws NotLoggedInException
     */
    public function getByUserAction() {
        $this->requireLogin();

        $user = $this->getCurrentUser();
        $userScores = $this->overwatchUserScoreService->getByUser($user);

        return $this->jsonResponse($userScores);
    }

    /**
     * @Route("/api/overwatch/scoreboard")
     * @Method({"GET"})
     *
     * @throws NotLoggedInException
     */
    public function getScoreboardAction() {
        $this->requireLogin();

        return $this->jsonResponse($this->overwatchUserScoreService->getScoreboard(OverwatchUserScore::MONTHLY_PERIOD));
    }
}