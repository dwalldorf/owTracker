<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\StopWatch;

class StopWatchTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getRuntime() {
        $sw = new StopWatch();
        $sw->start();

        sleep(1);
        $sw->stop();
        $runtime = $sw->getRuntimeInS();

        $this->assertTrue($runtime > 1.0);
        $this->assertTrue($runtime < 1.1);
    }

    /**
     * @test
     */
    public function getRuntimeInMs() {
        $sw = new StopWatch();
        $sw->setRuntime(1000.3281);

        $this->assertEquals('1000.328 ms', $sw->getRuntimeStringInMs());
    }

    /**
     * @test
     */
    public function getRuntimeInS() {
        $sw = new StopWatch();
        $sw->setRuntime(1000.0004);

        $this->assertEquals('1.000s', $sw->getRuntimeStringInS());
    }
}