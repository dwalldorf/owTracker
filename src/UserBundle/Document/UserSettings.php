<?php

namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class UserSettings {

    /**
     * @ODM\Field(name="follow_steam_ids", type="collection")
     * @var array
     */
    private $followSteamIds = [];

    /**
     * @ODM\Field(type="boolean")
     * @var bool
     */
    private $isAdmin = false;

    /**
     * @return string[]
     */
    public function getFollowSteamIds() {
        return $this->followSteamIds;
    }

    /**
     * @param array $followSteamIds
     */
    public function setFollowSteamIds($followSteamIds) {
        $this->followSteamIds = $followSteamIds;
    }

    /**
     * @return boolean
     */
    public function isAdmin() {
        return $this->isAdmin;
    }

    /**
     * @param boolean $isAdmin
     */
    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
}