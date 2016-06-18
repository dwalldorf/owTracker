<?php

namespace Tests\OverwatchBundle\Controller;

use AppBundle\DTO\BaseCollection;
use AppBundle\Util\AppSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class UserScoreControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function getByUserWithInvalidUserId() {
        $this->mockSessionUser();
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/someFakeId');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getByUserRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/someFakeId');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getHigherScores() {
        $this->mockSessionUser();

        $response = $this->apiRequest(Request::METHOD_GET, sprintf('/overwatch/scores/higher/%s/30', $this->mockedSessionUser->getId()));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getHigherScoresWithInvalidUserId() {
        $this->mockSessionUser();

        /* @var BaseCollection $responseCollection */
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/higher/someFakeId/30');
        $responseCollection = AppSerializer::getInstance()->fromJson($response->getContent(), BaseCollection::class);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(0, $responseCollection->getTotalItems());
    }

    /**
     * @test
     */
    public function getHigherScoresRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/higher/someFakeId/30');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getHigherScoresRequiresIntPeriod() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/higher/someFakeId/notAnInt');
    }

    /**
     * @test
     */
    public function getLowerScores() {
        $this->mockSessionUser();

        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/30');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getLowerScoresWithInvalidUserId() {
        $this->mockSessionUser();

        /* @var BaseCollection $responseCollection */
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/30');
        $responseCollection = AppSerializer::getInstance()->fromJson($response->getContent(), BaseCollection::class);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(0, $responseCollection->getTotalItems());
    }

    /**
     * @test
     */
    public function getLowerScoresRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/30');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getLowerScoresRequiresIntPeriod() {
        $response = $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/notAnInt');
    }
}