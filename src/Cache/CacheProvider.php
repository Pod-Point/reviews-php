<?php

namespace PodPoint\Reviews\Cache;

/**
 * Class CacheProvider
 */
class CacheProvider
{
    private static $instance = null;

    /**
     * CacheFactory constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * Get instance of Cache Driver/Adapter.
     *
     * @return LaravelCacheAdapter|null
     */
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new LaravelCacheAdapter();
        }

        return self::$instance;
    }
}
