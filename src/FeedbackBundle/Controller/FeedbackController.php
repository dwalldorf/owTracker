<?php

namespace FeedbackBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\DTO\BaseCollection;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\Service\FeedbackService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotAuthorizedException;
use UserBundle\Exception\NotLoggedInException;

class FeedbackController extends BaseController {

    /**
     * @var FeedbackService
     */
    private $feedbackService;

    protected function init() {
        $this->feedbackService = $this->getService(FeedbackService::ID);
    }

    /**
     * @Route("/api/feedback")
     * @Method("GET")
     *
     * @return Response
     * @throws NotLoggedInException
     * @throws NotAuthorizedException
     */
    public function getAllAction() {
        $this->requireAdmin();

        $limit = $this->getRequestParamAsInt('limit', 10, 50);
        $offset = $this->getRequestParamAsInt('offset');

        $feedbackCollection = new BaseCollection();
        $dbArray = $this->feedbackService->getAll($limit, $offset);
        $dtoArray = $this->feedbackService->toDto($dbArray);

        $feedbackCollection->setItems($dtoArray);
        return $this->json($feedbackCollection);
    }

    /**
     * @Route("/api/feedback/{id}")
     * @Method("GET")
     *
     * @return Response
     * @throws NotLoggedInException
     * @throws NotAuthorizedException
     */
    public function getByIdAction() {
        $this->requireAdmin();
        return $this->json('implement me');
    }

    /**
     * @Route("/api/feedback")
     * @Method("POST")
     *
     * @return Response
     * @throws NotLoggedInException
     */
    public function submitAction() {
        $this->requireLogin();
        $user = $this->getCurrentUser();

        /* @var $feedback Feedback */
        $feedback = $this->getEntityFromRequest(Feedback::class);
        $feedback->setCreatedBy($user->getId());
        $feedback->setCreatedTimestamp(new \DateTime());

        $dbFeedback = $this->feedbackService->save($feedback);

        return $this->json($dbFeedback, Response::HTTP_CREATED);
    }
}