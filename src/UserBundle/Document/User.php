<?php

namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt",
 *     collection="users",
 *     repositoryClass="UserBundle\Repository\UserRepository"
 * )
 */
class User {

    /**
     * @ODM\Id
     * @var string
     */
    protected $id;

    /**
     * @ODM\String
     * @ODM\Index(unique=true)
     * @var string
     */
    protected $username;

    /**
     * @ODM\String(nullable=false)
     * @ODM\Index(unique=true, order="asc")
     * @var string
     */
    protected $email;

    /**
     * @ODM\String
     * @var string
     */
    protected $password;

    /**
     * @ODM\Int(nullable=false)
     * @var int
     */
    private $registered;

    /**
     * @ODM\Bool
     * @var bool
     */
    private $isadmin = false;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
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

    /**
     * @return int
     */
    public function getRegistered() {
        return $this->registered;
    }

    /**
     * @param int $registered
     */
    public function setRegistered($registered) {
        $this->registered = $registered;
    }

    /**
     * @return boolean
     */
    public function isIsadmin() {
        return $this->isadmin;
    }

    /**
     * @param boolean $isadmin
     */
    public function setIsadmin($isadmin) {
        $this->isadmin = $isadmin;
    }
}