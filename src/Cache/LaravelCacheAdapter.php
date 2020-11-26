<?php

namespace PodPoint\Reviews\Cache;

use Illuminate\Support\Facades\Cache;

/**
 * Class LaravelCache
 */
class LaravelCacheAdapter
{
    /**
     * Returns cache by key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * Check if cache exists.
     *
     * @param $key
     *
     * @return boolean
     */
    public function has($key): bool
    {
        return Cache::has($key);
    }

    /**
     * Sets cache.
     *
     * @param string $key
     * @param $value
     * @param null $ttl
     *
     * @return boolean
     */
    public function set(string $key, $value, $ttl = null)
    {
        return Cache::put($key, $value, $ttl);
    }

    /**
     * Deletes cache.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function delete(string $key): bool
    {
        return Cache::forget($key);
    }

    public function clear()
    {
        //
    }

    /**
     * Returns multiple caches.
     *
     * @param array $keys
     * @param null $default
     *
     * @return array
     */
    public function getMultiple(array $keys, $default = null)
    {
        $cache = [];

        foreach ($keys as $key) {
            $cache[$key] = Cache::get($key);
        }

        return $cache;
    }

    /**
     * Sets multiple cache values.
     *
     * @param array $values
     * @param integer|null $ttl
     */
    public function setMultiple(array $values, int $ttl = null)
    {
        foreach ($values as $cacheKey => $value) {
            $this->set($cacheKey, $value, $ttl);
        }
    }

    /**
     * Deletes multiple cache keys.
     *
     * @param array $keys
     */
    public function deleteMultiple(array $keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }
}
