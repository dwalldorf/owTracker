<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class PrepareWebDistCommand extends ContainerAwareCommand {

    use ContainerAwareTrait;

    const DIST_FILES_PARAMETER_NAME = 'distFiles';

    const SOURCE_PREFIX = './node_modules/';

    const TARGET_PREFIX = './web/lib/';

    /**
     * @var int
     */
    private $copyCount = 0;

    protected function configure() {
        $this->setName('app:prepareWebDist')
            ->setDescription('Copies static vendor files to web directory');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     *
     * @throws RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        if (!$this->container->hasParameter(self::DIST_FILES_PARAMETER_NAME)) {
            throw new RuntimeException(sprintf("parameter '%s' not specified.", self::DIST_FILES_PARAMETER_NAME));
        }

        $resources = $this->container->getParameter(self::DIST_FILES_PARAMETER_NAME);
        $this->processResources($resources);

        $output->writeln('');
        $output->writeln('<info> [OK] copied ' . $this->copyCount . ' files</info>');
        $output->writeln('');
    }

    /**
     * @param array $resources
     */
    private function processResources(array $resources) {
        $this->createTargetDirectories($resources);

        foreach ($resources as $resourceType => $resource) {
            foreach ($resource as $resourceName) {
                $this->copyDistFile($resourceType, $resourceName);
            }
        }
    }

    /**
     * @param array $resources
     */
    private function createTargetDirectories(array $resources) {
        foreach ($resources as $resourceType => $resource) {
            $resourceTypeDir = self::TARGET_PREFIX . $resourceType;

            if (!is_dir($resourceTypeDir)) {
                mkdir($resourceTypeDir, 0777, true);
            }
        }
    }

    /**
     * @param string $type
     * @param string $distFile
     */
    private function copyDistFile($type, $distFile) {
        $source = self::SOURCE_PREFIX . $distFile;
        $target = self::TARGET_PREFIX . $type . '/' . $this->getFilenameWithoutPath($distFile);

        if (is_file($target)) {
            unlink($target);
        }
        copy($source, $target);
        $this->copyCount++;
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getFilenameWithoutPath($filename) {
        $filenameArray = array_reverse(explode('/', $filename));
        return $filenameArray[0];
    }
}