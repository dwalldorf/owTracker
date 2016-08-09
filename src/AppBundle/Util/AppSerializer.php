<?php

namespace AppBundle\Util;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppSerializer {

    const FORMAT = 'json';

    /**
     * @var AppSerializer
     */
    private static $instance;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var \JsonMapper
     */
    private $jsonMapper;

    /**
     * AppSerializer constructor.
     */
    private function __construct() {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->jsonMapper = new \JsonMapper();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new AppSerializer();
        }
        return self::$instance;
    }

    /**
     * @param mixed $obj
     * @param bool $escapeBackslash
     * @return string
     */
    public function toJson($obj, $escapeBackslash = true) {
        $json = $this->serializer->serialize($obj, self::FORMAT);

        if (!$escapeBackslash) {
            return $json;
        }
        return str_replace('\\', '', $json);
    }

    /**
     * @param $json
     * @param object $target
     * @return object
     */
    public function fromJson($json, $target) {
        $json = json_decode($json);
        return $this->jsonMapper->map($json, new $target());
    }

    /**
     * @param $json
     * @return array
     */
    public function toArray($json) {
        return json_decode($json, true);
    }
}