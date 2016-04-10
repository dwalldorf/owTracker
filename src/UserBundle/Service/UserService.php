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
     * @return int
     * @throws RegisterUserException
     */
    public function register(User $user) {
        $errors = $this->validateUser($user);
        if (count($errors) > 0) {
            throw new RegisterUserException('registration failed', $errors);
        }

        $user->setPassword($this->encryptPassword($user->getPassword()));
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
        if ($this->repository->findByEmail($email)) {
            $errors['email'][] = 'email already exists';
        }

        if (count($errors) > 0) {
            return $errors;
        }
        return null;
    }

    /**
     * @param User $user
     * @return User
     */
    public function login(User $user) {
        $dbUser = $this->repository->findByEmail($user->getEmail());

        if (!$dbUser) {
            return null;
        }

        if (password_verify($user->getPassword(), $dbUser->getPassword())) {
            $dbUser = $this->getSecureUserCopy($dbUser);
            $this->session->set('user', $dbUser);

            return $dbUser;
        }

        return null;
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