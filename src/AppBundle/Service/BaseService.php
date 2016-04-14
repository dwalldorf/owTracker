<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Document\User;

abstract class BaseService implements ContainerAwareInterface, IGetService, IGetRepository {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Session
     */
    protected $session;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;

        $this->session = $this->container->get('session');

        $this->init();
    }

    protected function init() {
    }

    public function getService($serviceId) {
        return $this->container->get($serviceId);
    }

    public function getRepository($repository) {
        return $this->container
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository($repository);
    }

    /**
     * @return User|null
     */
    public function getCurrentUser() {
        return $this->session->get('user');
    }
}