<?php

namespace PodPoint\Reviews\Cache;

use PodPoint\Reviews\Exceptions\CacheAdapterException;

/**
 * Class CacheProvider
 */
class CacheProvider
{
    /**
     * Cache instance of driver/adapter.
     *
     * @var null
     */
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
     * @return null
     * @throws CacheAdapterException
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            throw new CacheAdapterException();
        }

        return self::$instance;
    }
}
