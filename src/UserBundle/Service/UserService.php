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
        $errors = [];

        if (!$user->getEmail()) {
            $errors[] = 'email is mandatory';
        }
        if (!$user->getPassword()) {
            $errors[] = 'password is mandatory';
        }
        if ($this->repository->findByEmail($user->getEmail())) {
            $errors[] = 'email already registered';
        }

        if (count($errors) > 0) {
            throw new RegisterUserException($errors);
        }

        $user->setPassword($this->encryptPassword($user->getPassword()));
        return $this->repository->register($user);
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
        } else {
            /*
             * TODO: handle
             * by dwalldorf at 00:43 31.03.16
             */
        }
    }

    /**
     * temporary only - remove!
     *
     * @return User
     */
    public function getFakeUser() {
        $user = new User();
        $user->setId('123');
        $user->setEmail('d.walldorf@me.com');

        return $user;
    }

    /**
     * @param string $id
     * @return User|null
     */
    public function getUserById($id) {
        return $this->getFakeUser();
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

    /**
     * @return User[]
     */
    public function getAllUsers() {
        $retVal = [];
        $users = $this->repository->getAll();

        foreach ($users as $user) {
            $retVal[] = $this->getSecureUserCopy($user);
        }

        return $retVal;
    }
}