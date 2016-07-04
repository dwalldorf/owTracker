<?php

namespace DemoBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
use AppBundle\Service\BaseService;
use AppBundle\Util\AppSerializer;
use DemoBundle\Document\Demo;
use DemoBundle\Document\DemoFile;
use DemoBundle\Repository\DemoFileRepository;
use DemoBundle\Repository\DemoRepository;

class DemoService extends BaseService {

    const ID = 'demo.demo_service';

    /**
     * @var DemoRepository
     */
    private $demoRepository;

    /**
     * @var DemoFileRepository
     */
    private $demoFileRepository;

    protected function init() {
        $this->demoRepository = $this->getRepository(DemoRepository::ID);
        $this->demoFileRepository = $this->getRepository(DemoFileRepository::ID);
    }

    /**
     * @param Demo $demo
     * @return Demo
     *
     * @throws InvalidArgumentException
     */
    public function save(Demo $demo) {
        return $this->demoRepository->save($demo);
    }

    /**
     * @param string $userId
     * @return Demo[]
     */
    public function getByUser($userId) {
        return $this->demoRepository->findByUserId($userId);
    }

    public function saveDemoFile(DemoFile $demoFile) {
        return $this->demoFileRepository->save($demoFile);
    }

    /**
     * @param DemoFile $demoFile
     * @return DemoFile
     */
    public function publishDemoFile(DemoFile $demoFile) {
        $demoFile->setQueued();

        /* @var \OldSound\RabbitMqBundle\RabbitMq\Producer $producer */
        $producer = $this->container->get('old_sound_rabbit_mq.demo_upload_producer');
        $producer->setContentType('application/json');

        $message = AppSerializer::getInstance()->toJson($demoFile);
        $producer->publish($message);

        return $this->saveDemoFile($demoFile);
    }
}