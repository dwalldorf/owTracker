<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="demos",
 *     repositoryClass="DemoBundle\Repository\DemoRepository"
 * )
 */
class DemoInfo {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\String(name="user_id", nullable=false)
     * @ODM\Index(order="asc")
     */
    private $userId;

    /**
     * @var MatchInfo
     * @ODM\EmbedOne(targetDocument="MatchInfo")
     */
    private $matchInfo;

    /**
     * @var MatchRound[]
     * @ODM\EmbedMany(targetDocument="MatchRound")
     */
    private $rounds;

    /**
     * @param string $id
     * @param string $userId
     * @param MatchInfo $matchInfo
     * @param MatchRound[] $rounds
     */
    public function __construct($id = null, $userId = null, MatchInfo $matchInfo = null, array $rounds = []) {
        $this->id = $id;
        $this->userId = $userId;
        $this->matchInfo = $matchInfo;
        $this->rounds = $rounds;
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
     * @return MatchInfo
     */
    public function getMatchInfo() {
        return $this->matchInfo;
    }

    /**
     * @param MatchInfo $matchInfo
     */
    public function setMatchInfo($matchInfo) {
        $this->matchInfo = $matchInfo;
    }

    /**
     * @return MatchRound[]
     */
    public function getRounds() {
        return $this->rounds;
    }

    /**
     * @param MatchRound[] $rounds
     */
    public function setRounds(array $rounds) {
        $this->rounds = $rounds;
    }
}