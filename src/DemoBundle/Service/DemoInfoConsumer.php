<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use DemoBundle\Document\Demo;
use DemoBundle\Document\MatchInfo;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use UserBundle\Service\UserService;

class DemoInfoConsumer extends BaseService implements ConsumerInterface {

    const ID = 'demo.demo_info_consumer';

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var SteamService
     */
    private $steamService;

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
        $this->steamService = $this->getService(SteamService::ID);
        $this->userService = $this->getService(UserService::ID);
    }

    /**
     * @param AMQPMessage $msg
     * @return mixed
     */
    public function execute(AMQPMessage $msg) {
        $demo = new Demo();

        $mapper = new \JsonMapper();
        $mapper->map(json_decode($msg->getBody()), $demo);

        $demoFile = $this->demoService->getDemoFileById($demo->getId());

        if (!$demoFile) {
            // should never happen he said
            return true;
        }
        $demo->setUserId($demoFile->getUserId());
        $demo = $this->setPlayer64Ids($demo);

        $this->demoService->save($demo);

        unlink($demoFile->getFile());
        $demoFile->setProcessed(true);
        $demoFile->setFile(null);

        $this->demoService->saveDemoFile($demoFile);

        return false;
    }

    /**
     * @param Demo $demo
     * @return Demo
     */
    private function setPlayer64Ids(Demo $demo) {
        $matchInfo = $demo->getMatchInfo();
        $players = $matchInfo->getPlayers();
        foreach ($players as $index => $player) {
            $steamId64 = $this->steamService->getSteamId64($player->getSteamId());
            $players[$index]->setSteamId64($steamId64);
        }
        $matchInfo->setPlayers($players);
        $demo->setMatchInfo($matchInfo);

        return $demo;
    }
}