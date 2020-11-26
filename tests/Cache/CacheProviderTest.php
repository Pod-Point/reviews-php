<?php

namespace PodPoint\Reviews\Tests\Cache;

use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Exceptions\CacheAdapterException;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class CacheProviderTest
 */
class CacheProviderTest extends TestCase
{
    /**
     * The should return null when no cache adapter is set.
     */
    public function testGetInstance()
    {
        $this->registerCacheAdapter();
        $this->assertNotNull(CacheProvider::getInstance());
    }

    /**
     * The should throw CacheAdapterException when no cache adapter is set.
     */
    public function testGetInstanceGivenNoAdapterIsSetShouldThrowCacheAdapterException()
    {
        CacheProvider::setInstance(null);

        $this->expectException(CacheAdapterException::class);

        CacheProvider::getInstance();
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
