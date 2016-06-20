<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument()
 */
class MatchTeam {

    /**
     * @var string
     * @ODM\String(name="name")
     */
    private $teamName;

    /**
     * @var MatchPlayer[]
     * @ODM\EmbedMany(targetDocument="MatchPlayer")
     */
    private $players;

    /**
     * @param string $teamName
     * @param array $players
     */
    public function __construct($teamName = null, array $players = []) {
        $this->teamName = $teamName;
        $this->players = $players;
    }

    /**
     * @return string
     */
    public function getTeamName() {
        return $this->teamName;
    }

    /**
     * @param string $teamName
     */
    public function setTeamName($teamName) {
        $this->teamName = $teamName;
    }

    /**
     * @return MatchPlayer[]
     */
    public function getPlayers() {
        return $this->players;
    }

    /**
     * @param MatchPlayer[] $players
     */
    public function setPlayers(array $players) {
        $this->players = $players;
    }
}