<?php

namespace UserBundle\Service;

use AppBundle\Service\BaseService;
use UserBundle\Document\User;
use UserBundle\Exception\RegisterUserException;
use UserBundle\Repository\UserRepository;

class UserService extends BaseService {

    const ID = 'user.user_service';

    /**
     * @var UserRepository
     */
    private $repository;

    protected function init() {
        $this->repository = $this->getRepository(UserRepository::ID);
    }

    /**
     * @param User $user
     * @return string
     * @throws RegisterUserException
     */
    public function register(User $user) {
        $errors = $this->validateUser($user);
        if (count($errors) > 0) {
            throw new RegisterUserException('registration failed', $errors);
        }

        $user->setPassword($this->encryptPassword($user->getPassword()));
        $user->setRegistered(time());

        return $this->repository->register($user);
    }

    /**
     * @param User $user
     * @return array|null array of errors or null
     */
    private function validateUser(User $user) {
        $errors = [];

        $email = $user->getEmail();
        $password = $user->getPassword();

        if (!$email) {
            $errors['email'][] = 'email is mandatory';
        }
        if (!$password) {
            $errors[] = 'password is mandatory';
        }
        if ($this->repository->findByUsernameOrEmail($email)) {
            $errors['email'][] = 'email already exists';
        }

        if (count($errors) > 0) {
            return $errors;
        }
        return null;
    }

    /**
     * @param $loginName
     * @param $password
     * @return User
     */
    public function login($loginName, $password) {
        $dbUser = $this->repository->findByUsernameOrEmail($loginName);

        if (!$dbUser) {
            return null;
        }

        if (password_verify($password, $dbUser->getPassword())) {
            $dbUser = $this->getSecureUserCopy($dbUser);
            $this->session->set('user', $dbUser);

            return $dbUser;
        }

        return null;
    }

    /**
     * @param string $id
     * @return User
     */
    public function findById($id) {
        return $this->repository->findById($id);
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByUsernameOrEmail($email) {
        return $this->repository->findByUsernameOrEmail($email);
    }

    /**
     * @return \UserBundle\Document\User[]
     */
    public function getAllActiveUsers() {
        return $this->repository->getAll();
    }

    /**
     * @return User[]
     */
    public function getTestUsers() {
        return $this->repository->getTestUsers();
    }

    /**
     * @param User $user
     */
    public function deleteUser(User $user) {
        $this->repository->remove($user);
    }

    /**
     * @param User $user
     * @return User
     */
    private function getSecureUserCopy(User $user) {
        $user->setPassword(null);
        return $user;
    }

    /**
     * @param $password
     * @return string
     */
    private function encryptPassword($password) {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}