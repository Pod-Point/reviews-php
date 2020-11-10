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
     * Set instance.
     *
     * @param mixed $instance
     *
     * @return void
     */
    public static function setInstance($instance): void
    {
        self::$instance = $instance;
    }

    /**
     * Get instance of Cache Driver/Adapter.
     *
     * @return LaravelCacheAdapter|null
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LaravelCacheAdapter();
        }

        return self::$instance;
    }
}
