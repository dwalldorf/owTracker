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

        $sessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->_container->set('session', $sessionMock);

        $this->init();
    }

    protected function get($service) {
        return $this->_container->get($service);
    }

    protected function init() {
    }

    protected function mockService() {
    }

    protected function mockRepository($repositoryName, $mockRepository) {
        $this->_doctrineManager->method('getRepository')
            ->with($repositoryName)
            ->willReturn($mockRepository);
    }
}