<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="demo_stats",
 *     repositoryClass="DemoBundle\Repository\DemoStatsRepository"
 * )
 */
class DemoStats {

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string", name="demo_id")
     */
    private $demoId;

    /**
     * @var string
     * @ODM\Field(type="string", name="steam_id64")
     */
    private $steamId64;

    /**
     * @var string
     * @ODM\Field(type="string", name="user_id")
     */
    private $userId;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $kills = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $assists = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $headshots = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    private $headshotPercentage = 0.0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $deaths = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    private $kdr = 0.0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $bombPlants = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $bombDefuses = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $mvps = 0;

    /*
     * TODO: think of all the stats to collect per match
     * by dwalldorf at 19:36 21.08.16
     */

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
    public function getDemoId() {
        return $this->demoId;
    }

    /**
     * @param string $demoId
     * @return $this
     */
    public function setDemoId($demoId) {
        $this->demoId = $demoId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSteamId64() {
        return $this->steamId64;
    }

    /**
     * @param string $steamId64
     * @return $this
     */
    public function setSteamId64($steamId64) {
        $this->steamId64 = $steamId64;
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
     * @return int
     */
    public function getKills() {
        return $this->kills;
    }

    /**
     * @param int $kills
     * @return $this
     */
    public function setKills($kills) {
        $this->kills = $kills;
        return $this;
    }

    /**
     * @return $this
     */
    public function addKill() {
        $this->kills++;
        return $this;
    }

    /**
     * @return int
     */
    public function getAssists() {
        return $this->assists;
    }

    /**
     * @param int $assists
     * @return $this
     */
    public function setAssists($assists) {
        $this->assists = $assists;
        return $this;
    }

    /**
     * @return $this
     */
    public function addAssist() {
        $this->assists++;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeadshots() {
        return $this->headshots;
    }

    /**
     * @param int $headshots
     * @return $this
     */
    public function setHeadshots($headshots) {
        $this->headshots = $headshots;
        return $this;
    }

    /**
     * @return $this
     */
    public function addHeadshot() {
        $this->headshots++;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeadshotPercentage() {
        return $this->headshotPercentage;
    }

    /**
     * @param float $headshotPercentage
     * @return $this
     */
    public function setHeadshotPercentage($headshotPercentage) {
        $this->headshotPercentage = $headshotPercentage;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeaths() {
        return $this->deaths;
    }

    /**
     * @param int $deaths
     * @return $this
     */
    public function setDeaths($deaths) {
        $this->deaths = $deaths;
        return $this;
    }

    /**
     * @return $this
     */
    public function addDeath() {
        $this->deaths++;
        return $this;
    }

    /**
     * @return float
     */
    public function getKdr() {
        return $this->kdr;
    }

    /**
     * @param float $kdr
     * @return $this
     */
    public function setKdr($kdr) {
        $this->kdr = $kdr;
        return $this;
    }

    /**
     * @return int
     */
    public function getBombPlants() {
        return $this->bombPlants;
    }

    /**
     * @param int $bombPlants
     * @return $this
     */
    public function setBombPlants($bombPlants) {
        $this->bombPlants = $bombPlants;
        return $this;
    }

    /**
     * @return $this
     */
    public function addBombPlant() {
        $this->bombPlants++;
        return $this;
    }

    /**
     * @return int
     */
    public function getBombDefuses() {
        return $this->bombDefuses;
    }

    /**
     * @param int $bombDefuses
     * @return $this
     */
    public function setBombDefuses($bombDefuses) {
        $this->bombDefuses = $bombDefuses;
        return $this;
    }

    /**
     * @return $this
     */
    public function addBombDefuse() {
        $this->bombDefuses++;
        return $this;
    }

    /**
     * @return int
     */
    public function getMvps() {
        return $this->mvps;
    }

    /**
     * @param int $mvps
     * @return $this
     */
    public function setMvps($mvps) {
        $this->mvps = $mvps;
        return $this;
    }

    /**
     * @return $this
     */
    public function addMvp() {
        $this->mvps++;
        return $this;
    }
}