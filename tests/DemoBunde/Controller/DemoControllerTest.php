<?php

namespace Tests\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class DemoControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function postDemo() {
        $response = $this->apiRequest(Request::METHOD_POST, '/demos', null, $this->getDemoApiToken());
        $this->assertNotEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function postDemoRequiresApiToken() {
        $response = $this->apiRequest(Request::METHOD_POST, '/demos');

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}