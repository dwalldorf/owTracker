<?php

namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
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
     * @ODM\Field(type="string")
     * @ODM\Index(unique=true)
     * @var string
     */
    protected $username;

    /**
     * @ODM\Field(type="string", nullable=false)
     * @ODM\Index(unique=true, order="asc")
     * @var string
     */
    protected $email;

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $password;

    /**
     * @ODM\Field(type="int", nullable=false)
     * @var int
     */
    private $registered;

    /**
     * @ODM\Field(type="boolean")
     * @var bool
     */
    private $isAdmin = false;

    /**
     * User constructor.
     * @param string $id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int $registered
     * @param bool $isAdmin
     */
    public function __construct($id = null, $username = null, $email = null, $password = null, $registered = null, $isAdmin = false) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->registered = $registered;
        $this->isAdmin = $isAdmin;
    }

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
    public function isIsAdmin() {
        return $this->isAdmin;
    }

    /**
     * @param boolean $isAdmin
     */
    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
}