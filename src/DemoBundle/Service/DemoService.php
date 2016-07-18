<?php

namespace DemoBundle\Service;

use AppBundle\Exception\InvalidArgumentException;
use AppBundle\Service\BaseService;
use AppBundle\Util\AppSerializer;
use DemoBundle\Document\Demo;
use DemoBundle\Document\DemoFile;
use DemoBundle\Repository\DemoFileRepository;
use DemoBundle\Repository\DemoRepository;
use UserBundle\Document\User;

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
     * @param int $limit
     * @param int $offset
     * @return Demo[]
     */
    public function getByUser($userId, $limit, $offset) {
        return $this->demoRepository->findByUserId($userId, $limit, $offset);
    }

    /**
     * @param string $id
     * @return Demo
     */
    public function getById($id) {
        return $this->demoRepository->findById($id);
    }

    /**
     * @param DemoFile $demoFile
     * @return DemoFile
     */
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