<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseService implements ContainerAwareInterface, IGetService, IGetRepository {

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
        $this->init();
    }

    protected function init() {
    }

    public function getService($className) {
        return ServiceLoader::getService($className, $this->container);
    }

    public function getRepository($repository) {
        return $this->container
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository($repository);
    }
}