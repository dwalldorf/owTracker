<?php

namespace DemoBundle\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
trait TRoundEventWithSite {

    /**
     * @var int
     * @ODM\Field(type="int", name="site")
     */
    private $site;

    /**
     * @return int
     */
    public function getSite() {
        return $this->site;
    }

    /**
     * @param int $site
     */
    public function setSite($site) {
        $this->site = $site;
    }
}