<?php

namespace AppBundle\Service;

interface IGetRepository {

    /**
     * @param string $repository
     * @return object
     */
    public function getRepository($repository);

}