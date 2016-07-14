<?php

namespace Tests;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseTestCase extends \PHPUnit_Framework_TestCase {

    protected $_container;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $_doctrineManager;

    /**
     * @var Session
     */
    protected $_sessionMock;

    public function __construct() {
        parent::__construct();

        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $this->_container = $kernel->getContainer();

        $this->_doctrineManager = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $doctrineStub = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $doctrineStub->method('getManager')
            ->willReturn($this->_doctrineManager);
        $this->_container->set('doctrine_mongodb', $doctrineStub);

        $this->_sessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->updateSessionMock();

        $this->init();
    }

    protected function get($service) {
        return $this->_container->get($service);
    }

    protected function init() {
    }

    /**
     * @param string $serviceId
     * @param \PHPUnit_Framework_MockObject_MockObject $mockService
     */
    protected function mockService($serviceId, $mockService) {
        $this->_container->set($serviceId, $mockService);
    }

    /**
     * @param string $repositoryId
     * @param \PHPUnit_Framework_MockObject_MockObject $mockRepository
     */
    protected function mockRepository($repositoryId, $mockRepository) {
        $this->_doctrineManager->method('getRepository')
            ->with($repositoryId)
            ->willReturn($mockRepository);
    }

    protected function updateSessionMock() {
        $this->_container->set('session', $this->_sessionMock);
    }
}