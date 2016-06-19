<?php

namespace Tests\UserBundle\Controller;

use AppBundle\Util\AppSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;
use UserBundle\Document\User;

class UserControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function getMeRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/users/me');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getMe() {
        $this->mockSessionUser();

        /* @var User $responseUser */
        $response = $this->apiRequest(Request::METHOD_GET, '/users/me');
        $responseJson = $response->getContent();
        $responseUser = AppSerializer::getInstance()->fromJson($responseJson, User::class);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($this->mockedSessionUser->getId(), $responseUser->getId());
        $this->assertEquals($this->mockedSessionUser->getUsername(), $responseUser->getUsername());
        $this->assertEquals($this->mockedSessionUser->getEmail(), $responseUser->getEmail());
        $this->assertNull($responseUser->getPassword());
    }

    /**
     * @test
     */
    public function logout() {
        $this->mockSessionUser();

        $response = $this->apiRequest(Request::METHOD_POST, '/user/logout');
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function logoutWithoutLogin() {
        $response = $this->apiRequest(Request::METHOD_POST, '/user/logout');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}