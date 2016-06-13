<?php

namespace AppBundle\Service;

use AppBundle\Model\CacheKey;
use Lsw\MemcacheBundle\Cache\LoggingMemcache;

class CacheService extends BaseService {

    const ID = 'app.cache_service';

    const NAMESPACE_APP_DATA = 'owt_data';

    /**
     * @var LoggingMemcache
     */
    private $memcache;

    /**
     * @var int
     */
    private $namespaceKey;

    protected function init() {
        $this->memcache = $this->container->get('memcache.default');
    }

    /**
     * @param CacheKey $key
     * @param mixed $data
     * @param int $expire
     * @param int $flag
     * @return mixed unmodified $data
     */
    public function set(CacheKey $key, $data, $expire = 60, $flag = MEMCACHE_COMPRESSED) {
        $this->generateNamespaceIfNecessary();

        $keyString = $this->getPrefixedKey($key);
        $this->memcache->set($keyString, $data, $flag, $expire);

        return $data;
    }

    /**
     * @param CacheKey $key
     * @return array|string|void
     */
    public function get(CacheKey $key) {
        $this->generateNamespaceIfNecessary();

        $keyString = $this->getPrefixedKey($key);
        return $this->memcache->get($keyString);
    }

    public function invalidate() {
        if (!$this->generateNamespaceIfNecessary()) {
            $this->namespaceKey++;
            $this->memcache->set(self::NAMESPACE_APP_DATA, $this->namespaceKey);
        }
    }

    /**
     * Returns true if namespace did not exist and was created, false otherwise
     * @return bool
     */
    private function generateNamespaceIfNecessary() {
        $this->namespaceKey = $this->memcache->get(self::NAMESPACE_APP_DATA);

        if (!$this->namespaceKey) {
            $this->namespaceKey = mt_rand(0, 10000);
            $this->memcache->set(self::NAMESPACE_APP_DATA, $this->namespaceKey);
            return true;
        }
        return false;
    }

    /**
     * @param CacheKey $cacheKey
     * @return string
     */
    private function getPrefixedKey(CacheKey $cacheKey) {
        $this->generateNamespaceIfNecessary();
        return sprintf('%s:%d:%s', self::NAMESPACE_APP_DATA, $this->namespaceKey, $cacheKey->toString());
    }
}