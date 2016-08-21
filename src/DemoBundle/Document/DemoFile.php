<?php

namespace DemoBundle\Document;

use Doctrine\ODM\Couchdb\Mapping\Annotations as ODM;

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
     * @param string $file
     * @param string $userId
     * @param string $id
     * @param bool $processed
     * @param bool $queued
     */
    public function __construct($file = null, $userId = null, $id = null, $processed = false, $queued = false) {
        $this->file = $file;
        $this->userId = $userId;
        $this->id = $id;
        $this->processed = $processed;
        $this->queued = $queued;
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
     * @return string
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @return boolean
     */
    public function isProcessed() {
        return $this->processed;
    }

    /**
     * @param boolean $processed
     */
    public function setProcessed($processed = true) {
        $this->processed = $processed;
    }

    /**
     * @return boolean
     */
    public function isQueued() {
        return $this->queued;
    }

    /**
     * @param boolean $queued
     */
    public function setQueued($queued = true) {
        $this->queued = $queued;
    }
}