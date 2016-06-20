<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MatchInfo {

    /**
     * @var string
     * @ODM\String
     */
    private $map;

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
     * @ODM\Int(name="rounds_team1")
     */
    private $totalRoundsTeam1;

    /**
     * @var int
     * @ODM\Int(name="rounds_team2")
     */
    private $totalRoundsTeam2;

    /**
     * @param string $map
     * @param MatchTeam $team1
     * @param MatchTeam $team2
     * @param int $totalRoundsTeam1
     * @param int $totalRoundsTeam2
     */
    public function __construct(
        $map = null,
        MatchTeam $team1 = null,
        MatchTeam $team2 = null,
        $totalRoundsTeam1 = 0,
        $totalRoundsTeam2 = 0
    ) {
        $this->map = $map;
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->totalRoundsTeam1 = $totalRoundsTeam1;
        $this->totalRoundsTeam2 = $totalRoundsTeam2;
    }

    /**
     * @return string
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * @param string $map
     */
    public function setMap($map) {
        $this->map = $map;
    }

    /**
     * @return MatchTeam
     */
    public function getTeam1() {
        return $this->team1;
    }

    /**
     * @param MatchTeam $team1
     */
    public function setTeam1(MatchTeam $team1) {
        $this->team1 = $team1;
    }

    /**
     * @return MatchTeam
     */
    public function getTeam2() {
        return $this->team2;
    }

    /**
     * @param MatchTeam $team2
     */
    public function setTeam2(MatchTeam $team2) {
        $this->team2 = $team2;
    }

    /**
     * @return int
     */
    public function getTotalRoundsTeam1() {
        return $this->totalRoundsTeam1;
    }

    /**
     * @param int $totalRoundsTeam1
     */
    public function setTotalRoundsTeam1($totalRoundsTeam1) {
        $this->totalRoundsTeam1 = $totalRoundsTeam1;
    }

    /**
     * @return int
     */
    public function getTotalRoundsTeam2() {
        return $this->totalRoundsTeam2;
    }

    /**
     * @param int $totalRoundsTeam2
     */
    public function setTotalRoundsTeam2($totalRoundsTeam2) {
        $this->totalRoundsTeam2 = $totalRoundsTeam2;
    }
}