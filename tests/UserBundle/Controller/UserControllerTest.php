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
        $client = $this->apiRequest(Request::METHOD_GET, '/api/users/me');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getMe() {
        $user = $this->getMockUser();
        $session = $this->client->getContainer()->get('session');
        $session->set('user', $user);

        /* @var User $responseUser */
        $client = $this->apiRequest(Request::METHOD_GET, '/api/users/me');
        $responseJson = $client->getResponse()->getContent();
        $responseUser = AppSerializer::getInstance()->fromJson($responseJson, User::class);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals($user->getId(), $responseUser->getId());
        $this->assertEquals($user->getUsername(), $responseUser->getUsername());
        $this->assertEquals($user->getEmail(), $responseUser->getEmail());
        $this->assertNull($responseUser->getPassword());
    }

    /**
     * @return User
     */
    private function getMockUser() {
        $password = 'somePassword';
        $hashedPassword = '$2y$12$UK52MfBoKkMTCYhpvPEEOumh0qsSPezoJYWH.3HkuTjc4oqNyQBOu';

        return new User('5763199f8ead0ead6a8b4567', 'testUser', 'test@user.com', $hashedPassword);
    }
}