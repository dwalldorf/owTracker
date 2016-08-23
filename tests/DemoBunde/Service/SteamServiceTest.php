<?php

namespace Tests\DemoBundle\Service;

use DemoBundle\Service\SteamService;
use Tests\BaseTestCase;

class SteamServiceTest extends BaseTestCase {

    /**
     * @var SteamService
     */
    private $steamService;

    protected function init() {
        $this->steamService = $this->get(SteamService::ID);
    }

    /**
     * @test
     */
    public function getSteamId64() {
        $steamId = 'STEAM_1:0:4944134';
        $expectedSteamId = '76561197970153996';

        $this->assertEquals($expectedSteamId, $this->steamService->getSteamId64($steamId));
    }
}