<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use AppBundle\Util\AppSerializer;
use DemoBundle\Document\Demo;
use DemoBundle\Form\DemoType;
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

    protected function createForm($type, $data = null, array $options = []) {
        return $this->container->get('form.factory')->create($type, $data, $options);
    }

    /**
     * @param AMQPMessage $msg
     * @return mixed
     */
    public function execute(AMQPMessage $msg) {
        $demo = new Demo();
        $demoArray = AppSerializer::getInstance()->toArray($msg->getBody());

        /* @var $form \Symfony\Component\Form\Form */
        $form = $this->container->get('form.factory')->create(DemoType::class, $demo);
        $form->submit($demoArray);

        if ($form->isValid()) {
            $this->demoService->save($demo);
            return true;
        }

        return false;
    }
}