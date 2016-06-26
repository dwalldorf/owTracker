<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\BadRequestException;
use AppBundle\Exception\ServerErrorException;
use DemoBundle\Document\Demo;
use DemoBundle\Form\DemoType;
use DemoBundle\Service\DemoService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotAuthorizedException;

class DemoController extends BaseController {

    /**
     * @var DemoService
     */
    private $demoService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
    }

    /**
     * @Route("/api/demos")
     * @Method("POST")
     * @return Response
     *
     * @throws BadRequestException
     * @throws NotAuthorizedException
     * @throws ServerErrorException
     */
    public function postAction() {
        // for reference: https://jsfiddle.net/entek/37x25f13/
        $apiToken = $this->container->getParameter('demo_api_token');
        $this->validateApiToken($apiToken);

        $form = $this->createForm(DemoType::class, new Demo());
        $form->submit(json_decode($this->request->getContent(), true));

        if ($form->isValid()) {
            $demo = $this->demoService->save($form->getData());
            if ($demo->getId()) {
                return $this->json($demo, Response::HTTP_CREATED);
            }
        } else {
            throw new BadRequestException($form->getErrors(true));
        }
    }
}