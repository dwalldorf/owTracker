<?php

namespace Tests;

use AppBundle\Util\AppSerializer;
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
        $this->client = static::createClient(['environment' => 'test']);
        $this->beforeTest();
    }

    protected function beforeTest() {
    }

    /**
     * @param $method
     * @param $uri
     * @param mixed $content
     * @param string $apiToken
     * @param array $server
     * @param array $parameters
     * @param array $files
     * @return Response
     */
    protected function apiRequest($method, $uri, $content = null, $apiToken = null, $server = [], $parameters = [], $files = []) {
        if (!is_array($server)) {
            $server = [];
            $server['CONTENT_TYPE'] = 'application/json';
        }

        if ($apiToken) {
            $server['HTTP_API_TOKEN'] = $apiToken;
        }

        if ($content) {
            $content = AppSerializer::getInstance()->toJson($content);
        }

        $this->client->request($method, '/api' . $uri, $parameters, $files, $server, $content);
        return $this->client->getResponse();
    }

    /**
     * @param Response $response
     * @param $targetEntity
     * @return object
     */
    protected function getEntityFromRequest(Response $response, $targetEntity) {
        return AppSerializer::getInstance()->fromJson($response->getContent(), $targetEntity);
    }

    protected function mockSessionUser() {
        $hashedPassword = '$2y$12$UK52MfBoKkMTCYhpvPEEOumh0qsSPezoJYWH.3HkuTjc4oqNyQBOu'; // "somePassword" -> (without "")
        $this->mockedSessionUser = new User('5763199f8ead0ead6a8b4567', 'testUser', 'test@user.com', $hashedPassword);

        $session = $this->client->getContainer()->get('session');
        $session->set('user', $this->mockedSessionUser);
    }

    protected function mockService($mock, $serviceId) {
        $this->client->getContainer()->set($serviceId, $mock);
    }

    /**
     * @return string
     */
    protected function getDemoApiToken() {
        return $this->client->getContainer()->getParameter('demo_api_token');
    }
}