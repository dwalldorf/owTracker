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
    private $repository;

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
        $this->repository = $this->getRepository(FeedbackRepository::ID);
        $this->userService = $this->getService(UserService::ID);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Feedback[]
     */
    public function getAll($limit, $offset) {
        return $this->repository->getAll($limit, $offset);
    }

    /**
     * @param Feedback $feedback
     * @return Feedback
     */
    public function save(Feedback $feedback) {
        return $this->repository->save($feedback);
    }

    public function deleteByUser(User $user) {
        $this->repository->deleteByUserId($user->getId());
    }

    /**
     * @param \DateTime $from
     * @return int
     */
    public function getFeedbackCountByTime(\DateTime $from) {
        return $this->repository->getFeedbackCount($from);
    }

    /**
     * @return int
     */
    public function getTotalFeedbackCount() {
        return $this->repository->getFeedbackCount();
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