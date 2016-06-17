<?php

namespace Tests\OverwatchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class UserScoreControllerTest extends BaseWebTestCase {

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
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getLowerScoresRequiresLogin() {
        $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/30');
    }

    /**
     * @test
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getLowerScoresRequiresIntPeriod() {
        $this->apiRequest(Request::METHOD_GET, '/overwatch/scores/lower/someFakeId/notAnInt');
    }
}