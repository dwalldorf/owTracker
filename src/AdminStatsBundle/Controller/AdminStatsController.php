<?php

namespace AdminStatsBundle\Controller;

use AppBundle\Controller\BaseController;
use FeedbackBundle\Service\FeedbackService;
use OverwatchBundle\Service\OverwatchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Exception\NotAuthorizedException;
use UserBundle\Service\UserService;

class AdminStatsController extends BaseController {

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var FeedbackService
     */
    private $feedbackService;

    protected function init() {
        $this->overwatchService = $this->getService(OverwatchService::ID);
        $this->userService = $this->getService(UserService::ID);
        $this->feedbackService = $this->getService(FeedbackService::ID);
    }

    /**
     * @Route("/api/adminstats")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NotAuthorizedException
     */
    public function getDashboardStatsAction() {
        $this->requireAdmin();

        $d24h = new \DateTime('-1 day');
        $d7d = new \DateTime('-7 days');
        $d30d = new \DateTime('-30 days');

        $data = [
            'verdictsLast24h' => $this->overwatchService->getVerdictCountByTime($d24h),
            'verdictsLast7d'  => $this->overwatchService->getVerdictCountByTime($d7d),
            'verdictsLast30d' => $this->overwatchService->getVerdictCountByTime($d30d),
            'totalVerdicts'   => $this->overwatchService->getTotalVerdictCount(),

            'totalUsers'   => $this->userService->getTotalUserCount(),
            'usersLast24h' => $this->userService->getUserCountByTime($d24h),
            'usersLast7d'  => $this->userService->getUserCountByTime($d7d),
            'usersLast30d' => $this->userService->getUserCountByTime($d30d),

            'totalFeedback'   => $this->feedbackService->getTotalFeedbackCount(),
            'feedbackLast24h' => $this->feedbackService->getFeedbackCountByTime($d24h),
            'feedbackLast7d'  => $this->feedbackService->getFeedbackCountByTime($d7d),
            'feedbackLast30d' => $this->feedbackService->getFeedbackCountByTime($d30d),
        ];

        return $this->jsonResponse($data);
    }
}