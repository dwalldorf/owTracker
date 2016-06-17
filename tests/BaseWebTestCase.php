<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTestCase extends WebTestCase {

    /**
     * @var Client
     */
    protected $client;

    public function setUp() {
        $this->client = static::createClient();
        $this->beforeTest();
    }

    protected function beforeTest() {
    }

    /**
     * @param $method
     * @param $uri
     * @param array $parameter
     * @param array $files
     * @param array $server
     * @param null $content
     * @return Client
     */
    public function apiRequest($method, $uri, $parameter = [], $files = [], $server = [], $content = null) {
        $this->client->request($method, $uri, $parameter, $files, $server, $content);
        return $this->client;
    }
}