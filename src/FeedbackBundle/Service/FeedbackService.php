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
    private $userService;

    protected function init() {
        $this->feedbackRepository = $this->getRepository(FeedbackRepository::ID);
        $this->userService = $this->getService(UserService::ID);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Feedback[]
     */
    public function getAll($limit, $offset) {
        return $this->feedbackRepository->getAll($limit, $offset);
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

    public function getFeedbackCountByTime(\DateTime $from) {
        return $this->feedbackRepository->getFeedbackCount($from);
    }

    public function getTotalFeedbackCount() {
        return $this->feedbackRepository->getFeedbackCount();
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
            $user = $this->userService->findById($item->getCreatedBy());

            $dto = new FeedbackDto($user, $item);
            $retVal[] = $dto;
        }
        return $retVal;
    }
}