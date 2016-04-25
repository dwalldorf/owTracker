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
     * AppSerializer constructor.
     */
    public function __construct() {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new AppSerializer();
        }
        return self::$instance;
    }

    /**
     * @param mixed $obj
     * @return string
     */
    public function toJson($obj) {
        return $this->serializer->serialize($obj, self::FORMAT);
    }

    /**
     * @param $json
     * @param string $target
     * @return object
     */
    public function fromJson($json, $target) {
        return $this->serializer->deserialize($json, $target, self::FORMAT);
    }

    /**
     * @param $json
     * @return array
     */
    public function toArray($json) {
        return json_decode($json, true);
    }
}