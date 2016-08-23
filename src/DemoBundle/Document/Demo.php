<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="demos",
 *     repositoryClass="DemoBundle\Repository\DemoRepository"
 * )
 */
class Demo {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string", name="user_id", nullable=false)
     * @ODM\Index(order="asc")
     */
    private $userId;

    /**
     * @var bool
     * @ODM\Field(type="boolean")
     */
    private $analyzed = false;

    /**
     * @var MatchInfo
     * @ODM\EmbedOne(name="info", targetDocument="MatchInfo")
     */
    private $matchInfo;

    /**
     * @var MatchRound[]
     * @ODM\EmbedMany(name="rounds", targetDocument="MatchRound")
     */
    private $rounds;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return boolean
     */
    public function isAnalyzed() {
        return $this->analyzed;
    }

    /**
     * @param boolean $analyzed
     * @return $this
     */
    public function setAnalyzed($analyzed) {
        $this->analyzed = $analyzed;
        return $this;
    }

    /**
     * @return MatchInfo
     */
    public function getMatchInfo() {
        return $this->matchInfo;
    }

    /**
     * @param MatchInfo $matchInfo
     * @return $this
     */
    public function setMatchInfo($matchInfo = null) {
        $this->matchInfo = $matchInfo;
        return $this;
    }

    /**
     * @return MatchRound[]
     */
    public function getRounds() {
        return $this->rounds;
    }

    /**
     * @param MatchRound[] $rounds
     * @return $this
     */
    public function setRounds(array $rounds) {
        $this->rounds = $rounds;
        return $this;
    }
}