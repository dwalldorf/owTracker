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

        return $this->repository->save($user);
    }

    /**
     * @param User $user
     * @return array|null array of errors or null
     */
    private function validateUser(User $user) {
        $errors = [];

        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();

        if (!$username) {
            $errors['username'] = 'Username is mandatory.';
        }
        if (!$email) {
            $errors['email'] = 'Email is mandatory.';
        }
        if (!$password) {
            $errors['password'] = 'Password is mandatory.';
        }
        if ($this->repository->findByUsernameOrEmail($email) || $this->repository->findByUsernameOrEmail($username)) {
            $errors['identity'] = 'Email or username already exists.';
        }

        if (count($errors) > 0) {
            return $errors;
        }
        return null;
    }

    /**
     * @param User $user
     */
    public function update(User $user) {
        $this->repository->save($user);
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

    public function logout() {
        $this->session->clear();
        $this->session->invalidate();
    }

    /**
     * @param string $id
     * @return User
     */
    public function findById($id) {
        $user = $this->repository->findById($id);
        if (!$user) {
            return null;
        }

        return $this->getSecureUserCopy($user);
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByUsernameOrEmail($email) {
        $user = $this->repository->findByUsernameOrEmail($email);
        if (!$user) {
            return null;
        }

        return $this->getSecureUserCopy($user);
    }

    /**
     * @return \UserBundle\Document\User[]
     */
    public function getAllActiveUsers() {
        $retVal = [];
        foreach ($this->repository->getAll() as $user) {
            if ($user instanceof User) {
                $retVal[] = $this->getSecureUserCopy($user);
            }
        }
        return $retVal;
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