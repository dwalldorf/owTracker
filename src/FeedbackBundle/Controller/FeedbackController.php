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
        $this->requireLogin();

        $feedbackCollection = new BaseCollection();
        $feedbackCollection->setItems($this->feedbackService->getAll());

        return $this->jsonResponse($feedbackCollection);
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
        $this->requireLogin();
        return $this->jsonResponse('implement me');
    }

    /**
     * @Route("/api/feedback")
     * @Method("POST")
     *
     * @return Response
     * @throws NotLoggedInException
     * @throws NotAuthorizedException
     */
    public function postAction() {
        $this->requireLogin();
        $user = $this->getCurrentUser();

        /* @var $feedback Feedback */
        $feedback = $this->getEntityFromRequest(Feedback::class);
        $feedback->setCreatedBy($user->getId());
        $feedback->setCreatedTimestamp(new \DateTime());

        $this->feedbackService->save($feedback);

        return $this->jsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}