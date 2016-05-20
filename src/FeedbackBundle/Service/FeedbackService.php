<?php

namespace FeedbackBundle\Service;

use AppBundle\Service\BaseService;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\Repository\FeedbackRepository;
use UserBundle\Document\User;
use UserBundle\Exception\NotAuthorizedException;

class FeedbackService extends BaseService {

    const ID = 'feedback.feedback_service';

    /**
     * @var FeedbackRepository
     */
    private $feedbackRepository;

    protected function init() {
        $this->feedbackRepository = $this->getRepository(FeedbackRepository::ID);
    }

    /**
     * @return Feedback[]
     * @throws NotAuthorizedException
     */
    public function getAll() {
        $this->isAllowed();

        return $this->feedbackRepository->getAll();
    }

    /**
     * @param Feedback $feedback
     * @return Feedback
     */
    public function save(Feedback $feedback) {
        return $this->feedbackRepository->save($feedback);
    }

    public function deleteByUser(User $user) {
        $this->feedbackRepository->deleteByUserId($user->getId());
    }

    /**
     * @return bool
     * @throws NotAuthorizedException
     */
    private function isAllowed() {
        $user = $this->getCurrentUser();

        // TODO: implement!
        return true;
    }
}