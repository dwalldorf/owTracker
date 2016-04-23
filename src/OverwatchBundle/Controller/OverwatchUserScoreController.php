<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\Service\UserScoreService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Exception\NotLoggedInException;

class OverwatchUserScoreController extends BaseController {

    /**
     * @var UserScoreService
     */
    private $UserScoreService;

    protected function init() {
        $this->UserScoreService = $this->getService(UserScoreService::ID);
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
        $userScores = $this->UserScoreService->getByUser($user);

        return $this->jsonResponse($userScores);
    }

    /**
     * @Route("/api/overwatch/scoreboard")
     * @Method({"GET"})
     *
     * @throws NotLoggedInException
     */
    public function getScoreboardAction() {
        $retVal = [];

        $this->requireLogin();
        $user = $this->getCurrentUser();

        $period = $this->UserScoreService->getPeriod(UserScoreService::PERIOD_LAST_24H);
        $top10 = $this->UserScoreService->getTopTen($period);
        $userScore = $this->UserScoreService->getByUser($user, $period);
        $nextTen = $this->UserScoreService->getNextTen($userScore, $period);

        foreach ($top10 as $currentScore) {
            $score = new UserScore($period, $currentScore->getUserId());
            $score->setNumberOfOverwatches($currentScore->getNumberOfOverwatches());
            $retVal[] = $score;
        }
        $score = new UserScore($period, $userScore->getUserId());
        $score->setNumberOfOverwatches($userScore->getNumberOfOverwatches());
        $retVal[] = $score;
        foreach ($nextTen as $currentScore) {
            $score = new UserScore($period, $currentScore->getUserId());
            $score->setNumberOfOverwatches($currentScore->getNumberOfOverwatches());
            $retVal[] = $score;
        }

        ldd($retVal);
        return $this->jsonResponse($retVal);
    }
}