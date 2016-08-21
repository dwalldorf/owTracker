<?php

namespace DemoBundle\Document\Traits;

use Doctrine\ODM\Couchdb\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
trait TRoundEventWithUser {

    /**
     * @var int
     * @ODM\Field(type="int", name="user_id")
     * @ODM\Index
     */
    private $userId;

    /**
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }
}