<?php

namespace Tests\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class DemoControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function getAllRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/matches');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}