<?php

namespace Tests\DemoBundle\Service;

use AppBundle\Util\AppSerializer;
use AppBundle\Util\RandomUtil;
use DemoBundle\Document\MatchTeam;
use DemoBundle\Service\DemoInfoConsumer;
use DemoBundle\Service\DemoService;
use PhpAmqpLib\Message\AMQPMessage;
use Tests\BaseTestCase;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class DemoInfoConsumerTest extends BaseTestCase {

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | DemoService
     */
    private $demoService;

    protected function init() {
        $this->demoService = $this->getMockBuilder(DemoService::class)->getMock();
    }

    /**
     * @return DemoInfoConsumer
     */
    private function getConsumer() {
        return $this->get(DemoInfoConsumer::ID);
    }

    /**
     * @param mixed $body
     * @return AMQPMessage
     */
    private function getAMQPMessage($body) {
        return new AMQPMessage(AppSerializer::getInstance()->toJson($body));
    }

    private function getDemo() {
        $user = new User('123abc', 'testUser_DemoInfoConsumerTest', 'owtTestUser_DemoInfoConsumerTest', 'password');
        return RandomUtil::getRandomDemo($user);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject | DemoService
     */
    private function getDemoServiceMock() {
        return $this->getMockBuilder(DemoService::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject | UserService
     */
    private function getUserServiceMock() {
        return $this->getMockBuilder(UserService::class)->getMock();
    }

    /**
     * @test
     */
    public function validDemo() {
        $demo = $this->getDemo();

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->once())
            ->method('findById')
            ->with($demo->getUserId())
            ->willReturn(new User());
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->once())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute($this->getAMQPMessage($demo));
    }

    /**
     * @test
     */
    public function demoUserNotFound() {
        $demo = $this->getDemo();

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->once())
            ->method('findById')
            ->with($demo->getUserId())
            ->willReturn(null);
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoWithoutUserId() {
        $demo = $this->getDemo();
        $demo->setUserId(null);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');

        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoWithoutMap() {
        $demo = $this->getDemo();
        $matchInfo = $demo->getMatchInfo();
        $matchInfo->setMap(null);
        $demo->setMatchInfo($matchInfo);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoWithoutTeam() {
        $demo = $this->getDemo();
        $matchInfo = $demo->getMatchInfo();
        $matchInfo->setTeam1(new MatchTeam());
        $demo->setMatchInfo($matchInfo);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoPlayerWithoutSteamId() {
        $demo = $this->getDemo();
        $matchInfo = $demo->getMatchInfo();
        $team1 = $matchInfo->getTeam1();
        $players = $team1->getPlayers();
        $players[3]->setSteamId(null);
        $team1->setPlayers($players);
        $matchInfo->setTeam1($team1);
        $demo->setMatchInfo($matchInfo);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoPlayerWithoutName() {
        $demo = $this->getDemo();
        $matchInfo = $demo->getMatchInfo();
        $team1 = $matchInfo->getTeam1();
        $players = $team1->getPlayers();
        $players[1]->setName(null);
        $team1->setPlayers($players);
        $matchInfo->setTeam1($team1);
        $demo->setMatchInfo($matchInfo);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoRoundWithoutNumber() {
        $demo = $this->getDemo();
        $rounds = $demo->getRounds();
        $rounds[2]->setRoundNumber(null);
        $demo->setRounds($rounds);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }

    /**
     * @test
     */
    public function demoRoundWithoutDuration() {
        $demo = $this->getDemo();
        $rounds = $demo->getRounds();
        $rounds[7]->setRoundDuration(null);
        $demo->setRounds($rounds);

        $userServiceMock = $this->getUserServiceMock();
        $userServiceMock->expects($this->never())
            ->method('findById');
        $demoServiceMock = $this->getDemoServiceMock();
        $demoServiceMock->expects($this->never())
            ->method('save');
        $this->mockService(DemoService::ID, $demoServiceMock);
        $this->mockService(UserService::ID, $userServiceMock);

        $consumer = $this->getConsumer();
        $consumer->execute(new AMQPMessage(AppSerializer::getInstance()->toJson($demo)));
    }
}