<?php

namespace PodPoint\Reviews\Cache;

use Illuminate\Support\Facades\Cache;

/**
 * Class LaravelCache
 * @package PodPoint\Reviews\Cache
 */
class LaravelCacheAdapter
{
    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * Check if cache exists.
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return Cache::has($key);
    }

    public function set($key, $value, $ttl = null)
    {
        Cache::put($key, $value, $ttl);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return Cache::forget($key);
    }

    public function clear()
    {
        //
    }

    public function getMultiple($keys, $default = null)
    {
        $cache = [];

        foreach ($keys as $key) {
            $cache[$key] = Cache::get($key);
        }

        return $cache;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $value) {
            $this->set($value['key'], $value['value'], $ttl);
        }
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }
}
