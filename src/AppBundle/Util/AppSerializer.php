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
    private function __construct() {
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