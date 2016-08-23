<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;

class SteamService extends BaseService {

    const ID = 'demo.steam_service';

    const RANDOM_MAGIC_INT = 76561197960265728;

    /**
     * @param string $steamId
     * @return string
     */
    public function getSteamId64($steamId) {
        $exploded = explode(':', $steamId);
        $authId = $exploded[1];
        $steamId = $exploded[2];

        return ($steamId * 2) + ($authId + self::RANDOM_MAGIC_INT);
    }
}