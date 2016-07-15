<?php

namespace Tests\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class DemoUploadControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function uploadDemoRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_POST, '/demo');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}