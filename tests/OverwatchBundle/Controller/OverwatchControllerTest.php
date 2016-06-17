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
        $verdictJson = AppSerializer::getInstance()->toJson($verdict);

        $response = $this->apiRequest(Request::METHOD_POST, '/overwatch/verdicts', [], [], [], $verdictJson);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitSetsUserId() {
        $this->mockSessionUser();

        $verdict = new Verdict();
        $verdict->setMap('de_dust2');
        $verdict->setOverwatchDate(time());
        $verdictJson = AppSerializer::getInstance()->toJson($verdict);

        /* @var Verdict $responseVerdict */
        $response = $this->apiRequest(Request::METHOD_POST, '/overwatch/verdicts', [], [], [], $verdictJson);
        $responseVerdict = AppSerializer::getInstance()->fromJson($response->getContent(), Verdict::class);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertNotNull($responseVerdict->getId());
        $this->assertEquals($responseVerdict->getUserId(), $this->mockedSessionUser->getId());
        $this->assertEquals($verdict->getMap(), $responseVerdict->getMap());

        // cleanup
        $this->overwatchService->deleteByUser($this->mockedSessionUser);
    }
}