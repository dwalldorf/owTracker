<?php

namespace FeedbackBundle\DTO;

use FeedbackBundle\Document\Feedback;
use UserBundle\Document\User;

class FeedbackDto {

    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $createdBy;

    /**
     * @var \DateTime
     */
    private $createdTimestamp;

    /**
     * @var array
     */
    private $feedback;

    /**
     * @param User $user
     * @param Feedback $feedback
     */
    public function __construct(User $user, Feedback $feedback) {
        $this->createdBy = $user;
        $this->id = $feedback->getId();
        $this->feedback = $feedback->getFeedback();

        if ($feedback->getCreated()) {
            $this->createdTimestamp = $feedback->getCreated()->getTimestamp();
        }
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTimestamp() {
        return $this->createdTimestamp;
    }

    /**
     * @param \DateTime $createdTimestamp
     */
    public function setCreatedTimestamp($createdTimestamp) {
        $this->createdTimestamp = $createdTimestamp;
    }

    /**
     * @return array
     */
    public function getFeedback() {
        return $this->feedback;
    }

    /**
     * @param array $feedback
     */
    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }
}