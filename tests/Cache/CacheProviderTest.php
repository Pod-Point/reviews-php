<?php

namespace PodPoint\Reviews\Tests\Cache;

use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Cache\LaravelCacheAdapter;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class CacheProviderTest
 */
class CacheProviderTest extends TestCase
{
    /**
     * The default instance should return LaravelCacheAdapter.
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf(LaravelCacheAdapter::class, CacheProvider::getInstance());
    }

    /**
     * The set instance method should change the cache instance.
     */
    public function testSetInstance()
    {
        $mockedAdapter = \Mockery::mock('CacheAdapter');
        CacheProvider::setInstance($mockedAdapter);
        $this->assertInstanceOf($mockedAdapter->mockery_getName(), CacheProvider::getInstance());
    }
}
