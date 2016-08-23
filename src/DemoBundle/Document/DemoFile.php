<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="demoFiles",
 *     repositoryClass="DemoBundle\Repository\DemoFileRepository"
 * )
 */
class DemoFile {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string", name="user_id", nullable=false)
     * @ODM\Index(order="asc")
     */
    private $userId;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $file;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     */
    private $uploaded;

    /**
     * @var bool
     * @ODM\Field(type="boolean")
     */
    private $queued = false;

    /**
     * @var bool
     * @ODM\Field(type="boolean")
     */
    private $processed = false;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return $this
     */
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUploaded() {
        return $this->uploaded;
    }

    /**
     * @param \DateTime $uploaded
     * @return $this
     */
    public function setUploaded($uploaded) {
        $this->uploaded = $uploaded;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isProcessed() {
        return $this->processed;
    }

    /**
     * @param boolean $processed
     * @return $this
     */
    public function setProcessed($processed = true) {
        $this->processed = $processed;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isQueued() {
        return $this->queued;
    }

    /**
     * @param boolean $queued
     * @return $this
     */
    public function setQueued($queued = true) {
        $this->queued = $queued;
        return $this;
    }
}