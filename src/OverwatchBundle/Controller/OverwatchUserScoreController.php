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
        /*
         * TODO: think of something that makes sense
         * by dwalldorf at 18:50 22.04.16
         */

        $retVal = [];

        $this->requireLogin();
        $user = $this->getCurrentUser();

        $period = $this->overwatchUserScoreService->getPeriod(OverwatchUserScoreService::PERIOD_LAST_30_DAYS);
        $top10 = $this->overwatchUserScoreService->getTopTen($period);
        $userScore = $this->overwatchUserScoreService->getByUser($user, $period);
        $nextTen = $this->overwatchUserScoreService->getNextTen($userScore, $period);

        foreach ($top10 as $userScore) {
//            $retVal[$userScore->getNumberOfOverwatches()] = new OverwatchUserScore($period, $userScore->getUserId());
        }

        return $this->jsonResponse('implement me');
    }
}