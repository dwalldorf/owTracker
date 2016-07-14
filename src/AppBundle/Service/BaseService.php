<?php

namespace AppBundle\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Document\User;

abstract class BaseService implements ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * @var Session
     */
    protected $session;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
        $this->session = $this->container->get('session');
        $this->dm = $this->container
            ->get('doctrine_mongodb')
            ->getManager();

        $this->init();
    }

    protected function init() {
    }

    public function getService($serviceId) {
        return $this->container->get($serviceId);
    }

    public function getRepository($repositoryId) {
        return $this->dm->getRepository($repositoryId);
    }

    /**
     * @return User|null
     */
    public function getCurrentUser() {
        return $this->session->get('user');
    }
}