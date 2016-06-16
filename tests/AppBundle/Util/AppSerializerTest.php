<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\AppSerializer;
use UserBundle\Document\User;

class AppSerializerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function toJson() {
        $id = '5760408c8ead0eff358b4567';
        $username = 'testUser';
        $email = 'test@user.com';
        $registered = time();

        $testObj = new User($id, $username, $email, null, $registered);
        $expectedJson = sprintf(
            '{"id":"%s","username":"%s","email":"%s","password":null,"registered":%d,"isAdmin":false}',
            $id,
            $username,
            $email,
            $registered
        );
        $json = AppSerializer::getInstance()->toJson($testObj);
        $this->assertEquals($expectedJson, $json);
    }

    /**
     * @test
     */
    public function fromJson() {
        $id = '2726418f4ead0efd358b4564';
        $username = 'testUser';
        $email = 'user@test.com';
        $registered = time();

        $json = sprintf(
            '{"id":"%s","username":"%s","email":"%s","password":null,"registered":%d,"isAdmin":false}',
            $id,
            $username,
            $email,
            $registered
        );
        $object = AppSerializer::getInstance()->fromJson($json, User::class);

        $this->assertEquals($id, $object->getId());
        $this->assertEquals($username, $object->getUsername());
        $this->assertEquals($email, $object->getEmail());
        $this->assertEquals($registered, $object->getRegistered());
    }

    /**
     * @test
     */
    public function toArray() {
        $id = '2726418f4ead0efd358b4564';
        $username = 'testUser';
        $email = 'user@test.com';
        $registered = time();

        $json = sprintf(
            '{"id":"%s","username":"%s","email":"%s","password":null,"registered":%d,"isAdmin":false}',
            $id,
            $username,
            $email,
            $registered
        );
        $array = AppSerializer::getInstance()->toArray($json);

        $this->assertEquals($id, $array['id']);
        $this->assertEquals($username, $array['username']);
        $this->assertEquals($email, $array['email']);
        $this->assertEquals($registered, $array['registered']);
    }
}