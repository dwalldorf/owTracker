<?php

namespace Tests\DemoBundle\Controller;

use AppBundle\Util\RandomUtil;
use DemoBundle\Document\Demo;
use DemoBundle\Document\MatchInfo;
use DemoBundle\Document\MatchPlayer;
use DemoBundle\Document\MatchRound;
use DemoBundle\Document\MatchTeam;
use DemoBundle\Document\RoundEventKill;
use DemoBundle\Document\RoundEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class DemoControllerTest extends BaseWebTestCase {

    /**
     * TODO: rewrite
     */
    public function postDemo() {
        $this->mockSessionUser();
        $demo = $this->getTestDemo($this->mockedSessionUser->getId());

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());
        $resArray = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->assertNotNull($resArray['id']);
        $this->assertEquals($demo->getMatchInfo()->getMap(), $resArray['matchInfo']['map']);
        $this->assertEquals($demo->getMatchInfo()->getTeam1()->getTeamName(), $resArray['matchInfo']['team1']['teamName']);
        $this->assertEquals($demo->getMatchInfo()->getTeam2()->getTeamName(), $resArray['matchInfo']['team2']['teamName']);

        $round1Kills = $demo->getRounds()[0]->getRoundEvents()->getKills();
        $resRound1Kills = $resArray['rounds'][0]['roundEvents']['kills'];

        $this->assertEquals(count($round1Kills), count($resRound1Kills));
        $this->assertEquals($round1Kills[0]->getKiller(), $resRound1Kills[0]['killer']);
        $this->assertEquals($round1Kills[0]->getKilled(), $resRound1Kills[0]['killed']);
        $this->assertEquals($round1Kills[0]->getTimeInRound(), $resRound1Kills[0]['timeInRound']);
        $this->assertEquals($round1Kills[0]->isHeadshot(), $resRound1Kills[0]['headshot']);
    }

    /**
     * TODO: rewrite
     */
    public function postDemoWithoutUserId() {
        $this->mockSessionUser();
        $demo = $this->getTestDemo();

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('userId', $response->getContent());
    }

    /**
     * TODO: rewrite
     */
    public function postDemoWithoutMap() {
        $this->mockSessionUser();

        $demo = $this->getTestDemo($this->mockedSessionUser->getId());
        $matchInfo = $demo->getMatchInfo();
        $matchInfo->setMap(null);
        $demo->setMatchInfo($matchInfo);

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('map', $response->getContent());
    }

    /**
     * TODO: rewrite
     */
    public function postDemoWithoutTeam() {
        $demo = new Demo();

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());
        $this->assertTrue($response->getStatusCode() != Response::HTTP_UNAUTHORIZED);
    }

    /**
     * TODO: rewrite
     */
    public function postDemoPlayWithoutSteamId() {
        $this->mockSessionUser();

        $demo = $this->getTestDemo($this->mockedSessionUser->getId());
        $matchInfo = $demo->getMatchInfo();
        $team1 = $matchInfo->getTeam1();
        $players = $team1->getPlayers();
        $players[0]->setSteamId(null);
        $team1->setPlayers($players);
        $matchInfo->setTeam1($team1);
        $demo->setMatchInfo($matchInfo);

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('steamId', $response->getContent());
    }

    /**
     * TODO: rewrite
     */
    public function postDemoPlayWithoutName() {
        $this->mockSessionUser();

        $demo = $this->getTestDemo($this->mockedSessionUser->getId());
        $matchInfo = $demo->getMatchInfo();
        $team1 = $matchInfo->getTeam1();
        $players = $team1->getPlayers();
        $players[0]->setName(null);
        $team1->setPlayers($players);
        $matchInfo->setTeam1($team1);
        $demo->setMatchInfo($matchInfo);

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('name', $response->getContent());
    }

    /**
     * TODO: rewrite
     */
    public function postDemoRoundWithoutNumber() {
        $this->mockSessionUser();

        $demo = $this->getTestDemo($this->mockedSessionUser->getId());
        $rounds = $demo->getRounds();
        $rounds[0]->setRoundNumber(null);
        $demo->setRounds($rounds);

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('roundNumber', $response->getContent());
    }

    /**
     * TODO: rewrite
     */
    public function postDemoRoundWithoutDuration() {
        $this->mockSessionUser();

        $demo = $this->getTestDemo($this->mockedSessionUser->getId());
        $rounds = $demo->getRounds();
        $rounds[0]->setRoundDuration(null);
        $demo->setRounds($rounds);

        $response = $this->apiRequest(Request::METHOD_POST, '/demos', $demo, $this->getDemoApiToken());

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('roundDuration', $response->getContent());
    }

    private function getTestDemo($userId = null) {
        $team1Name = 'team1';
        $team2Name = 'team2';

        $team1 = $this->createTeam($team1Name);
        $team2 = $this->createTeam($team2Name);

        $team1Rounds = 16;
        $team2Rounds = 8;

        $map = 'de_dust2';
        $matchInfo = new MatchInfo($map, $team1, $team2, $team1Rounds, $team2Rounds);
        /* @var MatchRound[] $rounds */
        $rounds = [];

        for ($i = 0; $i < $team1Rounds; $i++) {
            $rounds[] = $this->createDemoRound($i + 1, $team1, $team2);
        }
        for ($i = 0; $i < $team2Rounds; $i++) {
            $rounds[] = $this->createDemoRound($i + 1, $team2, $team1);
        }
        return new Demo(null, $userId, $matchInfo, $rounds);
    }

    private function createTeam($name) {
        $players = [];
        for ($i = 0; $i < 5; $i++) {
            $players[] = new MatchPlayer(RandomUtil::getRandomString(5), RandomUtil::getRandomString());
        }
        return new MatchTeam($name, $players);
    }

    private function createDemoRound($roundNumber, MatchTeam $winner, MatchTeam $loser) {
        $kills = [];
        $winnerTeamPlayersAlive = $winner->getPlayers();
        $loserTeamPlayersAlive = $loser->getPlayers();

        foreach ($loserTeamPlayersAlive as $victim) {
            $killer = $winnerTeamPlayersAlive[mt_rand(0, count($winnerTeamPlayersAlive) - 1)];
            $kills[] = new RoundEventKill(
                $killer->getSteamId(), $victim->getSteamId(), null, RandomUtil::getRandomBoolWithProbability(0.3)
            );
        }

        return new MatchRound($roundNumber, mt_rand(30, 110), new RoundEvents($kills));
    }
}