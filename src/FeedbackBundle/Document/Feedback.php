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
     * @var string
     * @ODM\String
     */
    private $title;

    /**
     * @var string
     * @ODM\String
     */
    private $message;

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
     * @return mixed
     */
    public function getCreatedTimestamp() {
        return $this->createdTimestamp;
    }

    /**
     * @param mixed $createdTimestamp
     */
    public function setCreatedTimestamp($createdTimestamp) {
        $this->createdTimestamp = $createdTimestamp;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }
}