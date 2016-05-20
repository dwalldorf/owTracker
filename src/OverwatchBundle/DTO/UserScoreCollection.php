<?php

namespace OverwatchBundle\DTO;

use AppBundle\DTO\BaseCollection;

class UserScoreCollection extends BaseCollection {

    /**
     * @var bool
     */
    private $hasMore = false;

    /**
     * @return boolean
     */
    public function getHasMore() {
        return $this->hasMore;
    }

    /**
     * @param boolean $hasMore
     */
    public function setHasMore($hasMore = true) {
        $this->hasMore = $hasMore;
    }
}