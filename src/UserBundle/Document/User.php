<?php

namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document)
 */
class User {

    /**
     * @MongoDB\Id
     * @var \MongoId
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $email;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $password;

    /**
     * @return \MongoId
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param \MongoId $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }
}