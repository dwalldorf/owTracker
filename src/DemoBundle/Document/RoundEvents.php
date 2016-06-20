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
     * @ODM\EmbedOne(targetDocument="RoundEventBombPlant")
     */
    private $bombPlant;

    /**
     * @var RoundEventBombDefuse
     * @ODM\EmbedOne(targetDocument="RoundEventBombDefuse")
     */
    private $bombDefuse;

    /**
     * @param RoundEventKill[] $kills
     * @param RoundEventBombPlant $bombPlant
     * @param RoundEventBombDefuse $bombDefuse
     */
    public function __construct(array $kills = [], RoundEventBombPlant $bombPlant = null, RoundEventBombDefuse $bombDefuse = null) {
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
     * @return RoundEventBombDefuse
     */
    public function getBombDefuse() {
        return $this->bombDefuse;
    }

    /**
     * @param RoundEventBombDefuse $bombDefuse
     */
    public function setBombDefuse(RoundEventBombDefuse $bombDefuse) {
        $this->bombDefuse = $bombDefuse;
    }
}