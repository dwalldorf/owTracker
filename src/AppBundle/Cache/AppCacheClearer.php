<?php

namespace AppBundle\Cache;

use Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer;

class AppCacheClearer extends ChainCacheClearer {

    /**
     * @param string $cacheDir
     */
    public function clear($cacheDir) {
        $this->deleteRecursive(AppCacheWarmer::VENDOR_TARGET);
    }

    /**
     * @param string $dir
     * @return bool
     */
    private function deleteRecursive($dir) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            if (is_dir("$dir/$file")) {
                $this->deleteRecursive("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        return rmdir($dir);
    }
}