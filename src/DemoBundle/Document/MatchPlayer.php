<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MatchPlayer {

    /**
     * @var string
     * @ODM\Field(type="string", name="steam_id", nullable=false)
     */
    private $steamId;

    /**
     * @var int
     * @ODM\Field(type="int", name="user_id")
     */
    private $userId;

    /**
     * @var string
     * @ODM\Field(type="string", nullable=false)
     */
    private $name;

    /**
     * @param $steamId
     * @param null $userId
     * @param $name string
     */
    public function __construct($steamId = null, $userId = null, $name = null) {
        $this->steamId = $steamId;
        $this->userId = $userId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSteamId() {
        return $this->steamId;
    }

    /**
     * @param string $steamId
     * @return $this
     */
    public function setSteamId($steamId) {
        $this->steamId = $steamId;
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
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}