<?php

namespace AppBundle\Cache;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

class AppCacheWarmer extends CacheWarmer {

    const VENDOR_TARGET = 'web/lib';
    const JS_VENDOR_TARGET_PREFIX = '/js';

    private $jsVendor = [
        './node_modules' => [
            'jquery/dist/jquery.js',
            'jquery/dist/jquery.min.js',
            'angular/angular.js',
            'angular/angular.min.js'
        ],
    ];

    /**
     * @return bool true if the warmer is optional, false otherwise
     */
    public function isOptional() {
        return false;
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir) {
        $this->createTargetDirectories();

        foreach ($this->jsVendor as $dir => $files) {
            foreach ($files as $filename) {
                $this->copyFile($dir, $filename);
            }
        }
    }

    private function createTargetDirectories() {
        $jsDir = $this->getJsVendorPath();

        if (!is_dir($jsDir)) {
            mkdir($jsDir, 0777, true);
        }
    }

    /**
     * @param string $sourceDir
     * @param string $filename
     */
    private function copyFile($sourceDir, $filename) {
        $filenameWithoutPath = $this->getFilenameWithoutPath($filename);
        $source = $sourceDir . '/' . $filename;
        $target = $this->getJsVendorTarget($filenameWithoutPath);

        if (!is_file($target)) {
            copy($source, $target);
        }
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getFilenameWithoutPath($filename) {
        $f = explode('/', $filename);
        $f1 = array_reverse($f);
        return $f1[0];
    }

    /**
     * @return string
     */
    private function getJsVendorPath() {
        return self::VENDOR_TARGET . self::JS_VENDOR_TARGET_PREFIX;
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getJsVendorTarget($filename) {
        return $this->getJsVendorPath() . '/' . $filename;
    }
}