<?php

namespace FeedbackBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt",
 *     collection="feedback",
 *     repositoryClass="FeedbackBundle\Repository\FeedbackRepository"
 * )
 */
class Feedback {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\String(name="created_by", nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @ODM\Date(name="created", nullable=false)
     */
    private $createdTimestamp;

    /**
     * @var array
     * @ODM\Hash
     */
    private $feedback;

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
     * @return string
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
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