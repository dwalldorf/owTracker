<?php

namespace AppBundle\Cache;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

class AppCacheWarmer extends CacheWarmer {

    const VENDOR_TARGET = 'web/lib';
    const JS_VENDOR_TARGET_PREFIX = '/js/';
    const CSS_VENDOR_TARGET_PREFIX = '/css/';
    const FONTS_VENDOR_TARGET_PREFIX = '/fonts/';

    private $jsVendor = [
        './node_modules/' => [
            'jquery/dist/jquery.js',
            'jquery/dist/jquery.min.js',
            'angular/angular.js',
            'angular/angular.min.js',
            'bootstrap/dist/js/bootstrap.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'angular-cookies/angular-cookies.js',
            'angular-cookies/angular-cookies.min.js',
            'angular-cookies/angular-cookies.min.js.map',
            'angular-ui-router/release/angular-ui-router.js',
            'angular-ui-router/release/angular-ui-router.min.js',
        ],
    ];

    private $cssVendor = [
        './node_modules/' => [
            'bootstrap/dist/css/bootstrap.css',
            'bootstrap/dist/css/bootstrap.css.map',
            'bootstrap/dist/css/bootstrap.min.css',
            'bootstrap/dist/css/bootstrap.min.css.map',
        ],
    ];

    private $fontsVendor = [
        './node_modules/' => [
            'bootstrap/dist/fonts/glyphicons-halflings-regular.eot',
            'bootstrap/dist/fonts/glyphicons-halflings-regular.svg',
            'bootstrap/dist/fonts/glyphicons-halflings-regular.ttf',
            'bootstrap/dist/fonts/glyphicons-halflings-regular.woff',
            'bootstrap/dist/fonts/glyphicons-halflings-regular.woff2',
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

        $this->copyRecursive($this->jsVendor, self::VENDOR_TARGET . self::JS_VENDOR_TARGET_PREFIX);
        $this->copyRecursive($this->cssVendor, self::VENDOR_TARGET . self::CSS_VENDOR_TARGET_PREFIX);
        $this->copyRecursive($this->fontsVendor, self::VENDOR_TARGET . self::FONTS_VENDOR_TARGET_PREFIX);
    }

    private function createTargetDirectories() {
        $jsDir = $this->getJsVendorPath();
        $cssDir = $this->getCssVendorPath();
        $fontsDir = $this->getFontsVendorPath();

        if (!is_dir($jsDir)) {
            mkdir($jsDir, 0777, true);
        }
        if (!is_dir($cssDir)) {
            mkdir($cssDir, 0777, true);
        }
        if (!is_dir($fontsDir)) {
            mkdir($fontsDir, 0777, true);
        }
    }

    /**
     * @param string $source
     * @param string $targetDir
     */
    private function copyRecursive($source, $targetDir) {
        foreach ($source as $dir => $files) {
            foreach ($files as $filename) {
                $targetFilename = $this->getFilenameWithoutPath($filename);
                $this->copyFile($dir . $filename, $targetDir . $targetFilename);
            }
        }
    }

    /**
     * @param string $source
     * @param string $target
     */
    private function copyFile($source, $target) {
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
     * @return string
     */
    private function getCssVendorPath() {
        return self::VENDOR_TARGET . self::CSS_VENDOR_TARGET_PREFIX;
    }

    /**
     * @return string
     */
    private function getFontsVendorPath() {
        return self::VENDOR_TARGET . self::FONTS_VENDOR_TARGET_PREFIX;
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getJsVendorTarget($filename) {
        return $this->getJsVendorPath() . '/' . $filename;
    }
}