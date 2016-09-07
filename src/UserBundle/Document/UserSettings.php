<?php

namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class UserSettings {

    /**
     * @ODM\EmbedMany(name="follow_steam_ids", targetDocument="FollowSteamId")
     * @var FollowSteamId[]
     */
    private $followSteamIds = [];

    /**
     * @ODM\Field(type="boolean")
     * @var bool
     */
    private $isAdmin = false;

    /**
     * @return FollowSteamId[]
     */
    public function getFollowSteamIds() {
        return $this->followSteamIds;
    }

    /**
     * @return string[]
     */
    public function getFollowSteamIdsFlatArray() {
        $playersToTrack = [];
        foreach ($this->getFollowSteamIds() as $toFollow) {
            $playersToTrack[] = $toFollow->getId();
        }
        return $playersToTrack;
    }

    /**
     * @param FollowSteamId[]|null $followSteamIds
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