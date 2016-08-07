<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\EmbeddedDocument
 */
class MatchPlayer {

    /**
     * @var string
     * @ODM\Field(type="string", name="steam_id", nullable=false)
     *
     * @Assert\NotBlank(message="steamId for player is mandatory")
     */
    private $steamId;

    /**
     * @var int
     * @ODM\Field(type="int", name="user_id")
     *
     * @Assert\NotBlank(message="userId for player is mandatory")
     */
    private $userId;

    /**
     * @var string
     * @ODM\Field(type="string", nullable=false)
     *
     * @Assert\NotBlank(message="name for player is mandatory")
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