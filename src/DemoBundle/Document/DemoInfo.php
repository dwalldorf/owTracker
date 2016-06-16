<?php

namespace DemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="owt",
 *     collection="demos",
 *     repositoryClass="DemoBundle\Repository\DemoRepository"
 * )
 */
class DemoInfo {

}