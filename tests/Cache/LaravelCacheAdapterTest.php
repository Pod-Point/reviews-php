<?php

namespace PodPoint\Reviews\Tests\Cache;

use Illuminate\Support\Facades\Cache;
use PodPoint\Reviews\Cache\LaravelCacheAdapter;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class LaravelCacheAdapterTest
 */
class LaravelCacheAdapterTest extends TestCase
{
    /**
     * Instance of Laravel Cache Adapter.
     *
     * @var LaravelCacheAdapter
     */
    protected $cacheAdapter;

    /**
     * Prepares test instances.
     */
    protected function setUp()
    {
        $this->cacheAdapter = new LaravelCacheAdapter();
    }

    /**
     * Making sure that the get returns expected cache.
     */
    public function testGet()
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('foo', null)
            ->andReturn([
                         'sample_array' => ['origin' => 'earth'],
                        ]);

        $this->assertEquals([
                             'sample_array' => ['origin' => 'earth'],
                            ], $this->cacheAdapter->get('foo'));
    }

    /**
     * Making sure the has method calls the right laravel cache facade methods.
     */
    public function testHas()
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('foo')
            ->andReturnTrue();

        $actualReturn = $this->cacheAdapter->has('foo');
        $this->assertTrue($actualReturn);
    }
    
    /**
     * The set method should call laravel put method and return true.
     */
    public function testSet()
    {
        Cache::shouldReceive('put')
            ->once()
            ->with('foo', 'sample-content', 3600)
            ->andReturnTrue();

        $actualReturn = $this->cacheAdapter->set('foo', 'sample-content', 3600);
        $this->assertTrue($actualReturn);
    }

    /**
     * The delete method should call the laravel cache facade forget method and return true.
     */
    public function testDelete()
    {
        Cache::shouldReceive('forget')
            ->once()
            ->with('foo')
            ->andReturnTrue();

        $actualReturn = $this->cacheAdapter->delete('foo');
        $this->assertTrue($actualReturn);
    }

    /**
     * Get multiple should call laravel cache facade get multiple times for get multiple.
     */
    public function testGetMultiple()
    {
        $keys = [
                 'cache-key1',
                 'cache-key2',
                ];

        Cache::shouldReceive('get')
            ->once()
            ->with('cache-key1')
            ->andReturn(['sample' => 'content']);

        Cache::shouldReceive('get')
            ->once()
            ->with('cache-key2')
            ->andReturn('Cached content');

        $actualReturn = $this->cacheAdapter->getMultiple($keys);
        $this->assertEquals([
                             'cache-key1' => ['sample' => 'content'],
                             'cache-key2' => 'Cached content',
                            ], $actualReturn);
    }

    /**
     * Making sire the set multiple calls the set/put method.
     */
    public function testSetMultiple()
    {
        $cacheValues = [
                        'cache-key1' => ['sample' => 'content'],
                        'cache-key2' => 'Cached content',
                       ];

        Cache::shouldReceive('put')
            ->once()
            ->with('cache-key1', ['sample' => 'content'], 7200)
            ->andReturnTrue();

        Cache::shouldReceive('put')
            ->once()
            ->with('cache-key2', 'Cached content', 7200)
            ->andReturnTrue();

        $this->cacheAdapter->setMultiple($cacheValues, 7200);
        $this->assertTrue(true);
    }

    /**
     * Making sure the delete method calls the right laravel cache facade methods.
     */
    public function testDeleteMultiple()
    {
        $cacheValues = [
                        'cache-key1',
                        'cache-key2',
                       ];

        Cache::shouldReceive('forget')
            ->once()
            ->with('cache-key1')
            ->andReturnTrue();

        Cache::shouldReceive('forget')
            ->once()
            ->with('cache-key2')
            ->andReturnTrue();

        $this->cacheAdapter->deleteMultiple($cacheValues);
        $this->assertTrue(true);
    }
}
