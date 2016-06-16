<?php

namespace AppBundle\Command;

use AppBundle\Service\CacheService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InvalidateMemcacheAppDataCommand extends BaseContainerAwareCommand {

    const NAME = 'owt:memcache';

    /**
     * @var CacheService
     */
    private $cacheService;

    protected function configure() {
        $this->setName(self::NAME)
            ->setHelp('Invalidates memcache app data - sessions stay alive');
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $this->info('invalidating app data memcache');
        $this->cacheService->invalidate();
        $this->info('done');
    }

    protected function initServices() {
        $this->cacheService = $this->container->get(CacheService::ID);
    }
}