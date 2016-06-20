<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MatchPlayer {

    /**
     * @var string
     * @ODM\String(name="steam_id", nullable=false)
     */
    private $steamId;

    /**
     * @var string
     * @ODM\String(nullable=false)
     */
    private $name;

    /**
     * @param $steamId
     * @param $name
     */
    public function __construct($steamId = null, $name = null) {
        $this->steamId = $steamId;
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getSteamId() {
        return $this->steamId;
    }

    /**
     * @param null $steamId
     */
    public function setSteamId($steamId) {
        $this->steamId = $steamId;
    }

    /**
     * @return null
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name) {
        $this->name = $name;
    }
}