<?php

namespace DemoBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Exception\BadRequestException;
use DemoBundle\Document\DemoFile;
use DemoBundle\Service\DemoService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Exception\NotLoggedInException;

class DemoUploadController extends BaseController {

    const DEMO_BASE_PATH = '/usr/share/nginx/owt/var/data/demos';

    /**
     * @var DemoService
     */
    private $demoService;

    protected function init() {
        $this->demoService = $this->getService(DemoService::ID);
    }

    /**
     * @Route("/api/demo")
     * @Method("POST")
     * @return Response
     *
     * @throws NotLoggedInException
     * @throws BadRequestException
     */
    public function uploadDemoAction() {
        $this->requireLogin();

        if (!$this->request->files->has('file') || !count($this->request->files->get('file')) >= 1) {
            throw new BadRequestException('no files submitted');
        }

        $demos = [];

        foreach ($this->request->files->get('file') as $file) {
            $file = $this->moveFile($file);

            $demoFile = new DemoFile();
            $demoFile->setUserId($this->getCurrentUser()->getId());
            $demoFile->setFile($file->getPathname());

            $this->demoService->saveDemoFile($demoFile);
            $this->demoService->publishDemoFile($demoFile);

            $demos[] = $demoFile;
        }

        return $this->json($demos, 201);
    }

    /**
     * @param UploadedFile $file
     * @return File
     */
    private function moveFile(UploadedFile $file) {
        $path = self::DEMO_BASE_PATH . '/' . $this->getCurrentUser()->getId();
        $finalFilename = $path . '/' . $file->getClientOriginalName();

        if (is_file($finalFilename)) {
            $i = 0;
            while (is_dir($path . '/' . $i)) {
                $i++;
            }

            $path .= '/' . $i;
        }

        return $file->move($path, $file->getClientOriginalName());
    }
}