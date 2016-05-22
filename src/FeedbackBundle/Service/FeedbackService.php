<?php

namespace FeedbackBundle\Service;

use AppBundle\Service\BaseService;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\Repository\FeedbackRepository;
use UserBundle\Document\User;

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
     */
    public function getAll() {
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
}