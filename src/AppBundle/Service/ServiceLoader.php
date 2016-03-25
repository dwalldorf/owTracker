<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceLoader {

    /**
     * @param string $className
     * @param ContainerInterface $container
     * @return object
     */
    public static function getService($className, ContainerInterface $container) {
        return $container->get($className);
    }
}