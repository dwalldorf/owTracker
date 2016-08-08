<?php

namespace DemoBundle\Service;

use AppBundle\Service\BaseService;
use AppBundle\Util\AppSerializer;
use DemoBundle\Document\Demo;
use DemoBundle\Form\DemoType;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use UserBundle\Service\UserService;

class DemoInfoConsumer extends BaseService implements ConsumerInterface {

    const ID = 'demo.demo_info_consumer';

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var UserService
     */
    private $userService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
        $this->userService = $this->getService(UserService::ID);
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

        /*
         * TODO: read demo from db, get user and check from there
         * by dwalldorf at 19:01 08.08.16
         */
        if ($form->isValid()) {
            /*
            $user = $this->userService->findById($demo->getUserId());
            if (!$user) {
                // remove from queue and throw away
                return true;
            }

            $this->demoService->save($demo);
            return true;
            */
        }

        // do something with it - maybe write to an error queue
        return true;
    }
}