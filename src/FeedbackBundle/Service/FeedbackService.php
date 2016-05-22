<?php

namespace FeedbackBundle\Service;

use AppBundle\Service\BaseService;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\DTO\FeedbackDto;
use FeedbackBundle\Repository\FeedbackRepository;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class FeedbackService extends BaseService {

    const ID = 'feedback.feedback_service';

    /**
     * @var FeedbackRepository
     */
    private $feedbackRepository;

    /**
     * @var UserService
     */
    private $userservice;

    protected function init() {
        $this->feedbackRepository = $this->getRepository(FeedbackRepository::ID);
        $this->userservice = $this->getService(UserService::ID);
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

    /**
     * @param Feedback|Feedback[] $feedback
     * @return Feedback[]
     */
    public function toDto($feedback) {
        if ($feedback instanceof Feedback) {
            $feedback = [$feedback];
        }

        $retVal = [];
        foreach ($feedback as $item) {
            $user = $this->userservice->findById($item->getCreatedBy());

            $dto = new FeedbackDto($user, $item);
            $retVal[] = $dto;
        }
        return $retVal;
    }
}