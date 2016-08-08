<?php

namespace DemoBundle\Document;

use DemoBundle\Document\Traits\TRoundEventWithTimeInRound;
use DemoBundle\Document\Traits\TRoundEventWithUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

class RoundEventPlayerHurt extends RoundEvent {

    use TRoundEventWithUser;
    use TRoundEventWithTimeInRound;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $attacker;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $health;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    private $armor;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $weapon;

    /**
     * @var int
     * @ODM\Field(type="int", name="dmg_health")
     */
    private $dmgHealth;

    /**
     * @var int
     * @ODM\Field(type="int", name="dmg_armor")
     */
    private $dmgArmor;

    /**
     * @var
     */
    private $hitgroup;

    /**
     * @return int
     */
    public function getAttacker() {
        return $this->attacker;
    }

    /**
     * @param int $attacker
     */
    public function setAttacker($attacker) {
        $this->attacker = $attacker;
    }

    /**
     * @return int
     */
    public function getHealth() {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth($health) {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getArmor() {
        return $this->armor;
    }

    /**
     * @param int $armor
     */
    public function setArmor($armor) {
        $this->armor = $armor;
    }

    /**
     * @return string
     */
    public function getWeapon() {
        return $this->weapon;
    }

    /**
     * @param string $weapon
     */
    public function setWeapon($weapon) {
        $this->weapon = $weapon;
    }

    /**
     * @return int
     */
    public function getDmgHealth() {
        return $this->dmgHealth;
    }

    /**
     * @param int $dmgHealth
     */
    public function setDmgHealth($dmgHealth) {
        $this->dmgHealth = $dmgHealth;
    }

    /**
     * @return int
     */
    public function getDmgArmor() {
        return $this->dmgArmor;
    }

    /**
     * @param int $dmgArmor
     */
    public function setDmgArmor($dmgArmor) {
        $this->dmgArmor = $dmgArmor;
    }

    /**
     * @return mixed
     */
    public function getHitgroup() {
        return $this->hitgroup;
    }

    /**
     * @param mixed $hitgroup
     */
    public function setHitgroup($hitgroup) {
        $this->hitgroup = $hitgroup;
    }
}