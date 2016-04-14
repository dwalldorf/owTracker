<?php

namespace OverwatchBundle\Controller;

use AppBundle\Controller\BaseController;
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
    public function getAction() {
        $this->requireLogin();

        $user = $this->getCurrentUser();
        $userScores = $this->overwatchUserScoreService->getByUser($user);

        return $this->jsonResponse($userScores);
    }
}