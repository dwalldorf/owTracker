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
     * @var UserSettings
     * @ODM\EmbedOne(name="settings", targetDocument="UserSettings")
     */
    private $userSettings;

    /**
     * User constructor.
     * @param string $id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int $registered
     */
    public function __construct($id = null, $username = null, $email = null, $password = null, $registered = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->registered = $registered;

        $this->userSettings = new UserSettings();
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
     * @param string|null $password
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
     * @param int|null $registered
     */
    public function setRegistered($registered) {
        $this->registered = $registered;
    }

    /**
     * @return UserSettings
     */
    public function getUserSettings() {
        return $this->userSettings;
    }

    /**
     * @param UserSettings $userSettings
     */
    public function setUserSettings($userSettings) {
        $this->userSettings = $userSettings;
    }
}