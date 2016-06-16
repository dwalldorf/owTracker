<?php

namespace AppBundle\Service;

interface IGetRepository {

    /**
     * @param string $repositoryId
     * @return object
     */
    public function getRepository($repositoryId);

}