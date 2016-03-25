<?php

namespace AppBundle\Service;

interface IGetService {

    /**
     * @param $className
     * @return object
     */
    public function getService($className);
}
