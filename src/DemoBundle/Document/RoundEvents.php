<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class RoundEvents {

    /**
     * @var RoundEventKill[]
     * @ODM\EmbedMany(targetDocument="RoundEventKill")
     */
    private $kills;

    /**
     * @var RoundEventBombPlant
     * @ODM\EmbedOne(name="plant", targetDocument="RoundEventBombPlant")
     */
    private $bombPlant;

    /**
     * @var RoundEventBombDefused
     * @ODM\EmbedOne(name="defuse", targetDocument="RoundEventBombDefused")
     */
    private $bombDefuse;

    /**
     * @param RoundEventKill[] $kills
     * @param RoundEventBombPlant $bombPlant
     * @param RoundEventBombDefused $bombDefuse
     */
    public function __construct(array $kills = [], RoundEventBombPlant $bombPlant = null, RoundEventBombDefused $bombDefuse = null) {
        $this->kills = $kills;
        $this->bombPlant = $bombPlant;
        $this->bombDefuse = $bombDefuse;
    }

    /**
     * @return RoundEventKill[]
     */
    public function getKills() {
        return $this->kills;
    }

    /**
     * @param RoundEventKill[] $kills
     */
    public function setKills(array $kills) {
        $this->kills = $kills;
    }

    /**
     * @return RoundEventBombPlant
     */
    public function getBombPlant() {
        return $this->bombPlant;
    }

    /**
     * @param RoundEventBombPlant $bombPlant
     */
    public function setBombPlant(RoundEventBombPlant $bombPlant) {
        $this->bombPlant = $bombPlant;
    }

    /**
     * @return RoundEventBombDefused
     */
    public function getBombDefuse() {
        return $this->bombDefuse;
    }

    /**
     * @param RoundEventBombDefused $bombDefuse
     */
    public function setBombDefuse(RoundEventBombDefused $bombDefuse) {
        $this->bombDefuse = $bombDefuse;
    }
}