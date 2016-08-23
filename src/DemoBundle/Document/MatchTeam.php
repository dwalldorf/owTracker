<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument()
 */
class MatchTeam {

    /**
     * @var string
     * @ODM\Field(type="string", name="name")
     */
    private $teamName;

    /**
     * @var int
     * @ODM\Field(type="int", name="n")
     */
    private $teamNumber;

    /**
     * @var MatchPlayer[]
     * @ODM\EmbedMany(targetDocument="MatchPlayer")
     */
    private $players;

    /**
     * @param string $teamName
     * @param array $players
     */
    public function __construct($teamName = null, $teamNumber = null, array $players = []) {
        $this->teamName = $teamName;
        $this->teamNumber = $teamNumber;
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
     * @return int
     */
    public function getTeamNumber() {
        return $this->teamNumber;
    }

    /**
     * @param int $teamNumber
     */
    public function setTeamNumber($teamNumber) {
        $this->teamNumber = $teamNumber;
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