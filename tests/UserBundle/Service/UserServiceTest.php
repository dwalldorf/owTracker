<?php

namespace Tests\UserBundle\Service;

use Tests\BaseTestCase;
use UserBundle\Document\User;
use UserBundle\Repository\UserRepository;
use UserBundle\Service\UserService;

class UserServiceTest extends BaseTestCase {

    /**
     * @test
     */
    public function login() {
        $loginName = 'username';
        $email = 'test@email.com';
        $password = 'password';
        $dbUser = new User('daf23131', $loginName, $email, '$2y$12$3BscgsqCJvZIDo60u/WhNegCE/LqhXzefjUk8CZMO.uLdJPUKKpYe');

        $repoMock = $this->getUserRepositoryMock();
        $repoMock->method('findByUsernameOrEmail')
            ->with($loginName)
            ->willReturn($dbUser);
        $repoMock->expects($this->once())
            ->method('findByUsernameOrEmail')
            ->with($loginName);

        $this->mockRepository(UserRepository::ID, $repoMock);

        /* @var UserService $userService */
        $userService = $this->get(UserService::ID);
        $loginUser = $userService->login($loginName, $password);

        $this->assertNotNull($loginUser);
        $this->assertEquals($loginName, $loginUser->getUsername());
        $this->assertEquals($email, $loginUser->getEmail());
        $this->assertNull($loginUser->getPassword());
    }

    /**
     * @test
     */
    public function loginWithUnkownUsername() {
        $loginName = 'username';
        $password = 'password';

        $repoMock = $this->getUserRepositoryMock();
        $repoMock->method('findByUsernameOrEmail')
            ->with($loginName)
            ->willReturn(null);
        $repoMock->expects($this->once())
            ->method('findByUsernameOrEmail')
            ->with($loginName);

        $this->mockRepository(UserRepository::ID, $repoMock);

        /* @var UserService $userService */
        $userService = $this->get(UserService::ID);
        $loginUser = $userService->login($loginName, $password);

        $this->assertNull($loginUser);
    }

    /**
     * @test
     */
    public function loginWithWrongPassword() {
        $loginName = 'username';
        $password = 'password'; // password hash doesn't match password
        $dbUser = new User('daf23131', $loginName, null, '$2y$12$3BscgsqCJvZ2Do60u/WhNegCE/LqhXzefjUk8CZMO.uLdJPUKKpYe');

        $repoMock = $this->getUserRepositoryMock();
        $repoMock->method('findByUsernameOrEmail')
            ->with($loginName)
            ->willReturn($dbUser);
        $repoMock->expects($this->once())
            ->method('findByUsernameOrEmail')
            ->with($loginName);

        $this->mockRepository(UserRepository::ID, $repoMock);

        /* @var UserService $userService */
        $userService = $this->get(UserService::ID);
        $loginUser = $userService->login($loginName, $password);

        $this->assertNull($loginUser);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getUserRepositoryMock() {
        return $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}