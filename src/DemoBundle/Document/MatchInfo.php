<?php

namespace DemoBundle\Document;

use Doctrine\ODM\Couchdb\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\EmbeddedDocument
 */
class MatchInfo {

    /**
     * @var string
     * @ODM\Field(type="string", nullable=false)
     * @ODM\Index(order="asc")
     */
    private $map;

    /**
     * @var string
     * @ODM\Field(type="string", name="server_name")
     */
    private $serverName;

    /**
     * @var MatchTeam
     * @ODM\EmbedOne(targetDocument="MatchTeam")
     */
    private $team1;

    /**
     * @var MatchTeam
     * @ODM\EmbedOne(targetDocument="MatchTeam")
     */
    private $team2;

    /**
     * @var int
     * @ODM\Field(type="int", name="rounds_team1")
     */
    private $totalRoundsTeam1;

    /**
     * @var int
     * @ODM\Field(type="int", name="rounds_team2")
     */
    private $totalRoundsTeam2;

    /**
     * @var
     */
    private $duration;

    /**
     * @return string
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * @param string $map
     * @return $this
     */
    public function setMap($map) {
        $this->map = $map;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerName() {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     * @return $this
     */
    public function setServerName($serverName) {
        $this->serverName = $serverName;
        return $this;
    }

    /**
     * @return MatchTeam
     */
    public function getTeam1() {
        return $this->team1;
    }

    /**
     * @param MatchTeam $team1
     * @return $this
     */
    public function setTeam1(MatchTeam $team1) {
        $this->team1 = $team1;
        return $this;
    }

    /**
     * @return MatchTeam
     */
    public function getTeam2() {
        return $this->team2;
    }

    /**
     * @param MatchTeam $team2
     * @return $this
     */
    public function setTeam2(MatchTeam $team2) {
        $this->team2 = $team2;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalRoundsTeam1() {
        return $this->totalRoundsTeam1;
    }

    /**
     * @param int $totalRoundsTeam1
     * @return $this
     */
    public function setTotalRoundsTeam1($totalRoundsTeam1) {
        $this->totalRoundsTeam1 = $totalRoundsTeam1;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalRoundsTeam2() {
        return $this->totalRoundsTeam2;
    }

    /**
     * @param int $totalRoundsTeam2
     * @return $this
     */
    public function setTotalRoundsTeam2($totalRoundsTeam2) {
        $this->totalRoundsTeam2 = $totalRoundsTeam2;
        return $this;
    }
}