<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Document\User;

class BaseWebTestCase extends WebTestCase {

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var User
     */
    protected $mockedSessionUser;

    public function setUp() {
        $this->client = static::createClient();
        $this->beforeTest();
    }

    protected function beforeTest() {
    }

    /**
     * @param $method
     * @param $uri
     * @param null $content
     * @param array $parameters
     * @param array $files
     * @param array $server
     * @return Response
     */
    protected function apiRequest($method, $uri, $content = null, $parameters = [], $files = [], $server = []) {
        $parameters['CONTENT_TYPE'] = 'application/json';

        $this->client->request($method, '/api' . $uri, $parameters, $files, $server, $content);
        return $this->client->getResponse();
    }

    protected function mockSessionUser() {
        $hashedPassword = '$2y$12$UK52MfBoKkMTCYhpvPEEOumh0qsSPezoJYWH.3HkuTjc4oqNyQBOu'; // "somePassword" -> (without "")
        $this->mockedSessionUser = new User('5763199f8ead0ead6a8b4567', 'testUser', 'test@user.com', $hashedPassword);

        $session = $this->client->getContainer()->get('session');
        $session->set('user', $this->mockedSessionUser);
    }
}