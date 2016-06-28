<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateIndicesCommand extends BaseContainerAwareCommand {

    protected function configure() {
        $this->setName('owt:createIndices')
            ->setHelp('Ensure mongo indices are created');
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $dm = $this->container->get('doctrine.odm.mongodb.document_manager');
        $dm->getSchemaManager()->ensureIndexes();
    }
}