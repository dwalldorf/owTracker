<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class DemoInfoConsumer extends BaseService implements ConsumerInterface {

    /**
     * @var DemoService
     */
    private $demoService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
    }

    /**
     * @param AMQPMessage $msg
     * @return mixed
     */
    public function execute(AMQPMessage $msg) {
        return false;
    }
}