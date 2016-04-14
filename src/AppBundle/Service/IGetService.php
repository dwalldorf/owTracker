<?php

namespace AppBundle\Service;

interface IGetService {

    /**
     * @param string $serviceId
     * @return object
     */
    public function getService($serviceId);
}
