<?php

namespace Tests\OverwatchBundle\Controller;

use AppBundle\Util\AppSerializer;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Service\OverwatchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class OverwatchControllerTest extends BaseWebTestCase {

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    protected function beforeTest() {
        $this->overwatchService = $this->client->getContainer()->get(OverwatchService::ID);
    }

    /**
     * @test
     */
    public function getByUser() {
        $this->mockSessionUser();

        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/verdicts/someFakeID');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getByUserRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/verdicts/someFakeID');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitRequiresLogin() {
        $verdict = new Verdict();
        $verdict->setMap('de_dust2');

        $response = $this->apiRequest(Request::METHOD_POST, '/overwatch/verdicts', $verdict);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitSetsUserId() {
        $this->mockSessionUser();

        $verdict = new Verdict();
        $verdict->setMap('de_dust2');

        /* @var Verdict $responseVerdict */
        $response = $this->apiRequest(Request::METHOD_POST, '/overwatch/verdicts', $verdict);
        $responseVerdict = $this->getEntityFromRequest($response, Verdict::class);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertNotNull($responseVerdict->getId());
        $this->assertEquals($responseVerdict->getUserId(), $this->mockedSessionUser->getId());
        $this->assertEquals($verdict->getMap(), $responseVerdict->getMap());

        // cleanup
        $this->overwatchService->deleteByUser($this->mockedSessionUser);
    }

    /**
     * @test
     */
    public function getMapPoolDoesNotRequireLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/mappool');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getMapPool() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/mappool');

        $mapPool = $this->overwatchService->getMapPool();
        $jsonMapPool = AppSerializer::getInstance()->toJson($mapPool);

        $this->assertEquals($jsonMapPool, $response->getContent());
    }
}