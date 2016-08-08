<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\RandomUtil;
use Tests\BaseTestCase;

class RandomUtilTest extends BaseTestCase {

    /**
     * @test
     */
    public function getRandomIntWithNotIn() {
        $notIn = [];

        for ($i = 0; $i < 100; $i++) {
            $random = RandomUtil::getRandomInt(0, 100, $notIn);

            $this->assertTrue(!in_array($random, $notIn));

            $notIn[] = $random;
        }
        $this->assertEquals(100, count($notIn));
    }
}