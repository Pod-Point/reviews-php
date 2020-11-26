<?php

namespace PodPoint\Reviews\Tests\Cache;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\Cache\AbstractHasCacheTtlInResponse;
use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Tests\TestCase;
use PodPoint\Reviews\TimeUnitConverter;
use Psr\SimpleCache\CacheInterface;

class AbstractHasCacheTtlInResponseTest extends TestCase
{
    /**
     * Mocked request used for returning getRequest.
     *
     * @var Request|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $mockedGuzzleRequest;

    /**
     * Mock of Http Client, used to pass to api client for making requests.
     *
     * @var \Mockery\Mock
     */
    protected $httpClient;

    /**
     * Instance of mocked cached Adapter.
     *
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|CacheInterface
     */
    protected $cacheAdapter;

    /**
     * Preparing test instances.
     */
    protected function setUp()
    {
        $this->cacheAdapter = \Mockery::mock(CacheInterface::class);
        CacheProvider::setInstance($this->cacheAdapter);

        $this->mockedGuzzleRequest = \Mockery::mock(Request::class);
        $this->httpClient = \Mockery::mock(Client::class, ['http_errors' => true])->makePartial();
    }

    /**
     * Making sure that the expires_in is converted in minutes and used as ttl for cache.
     */
    public function testGetCacheableTtlFromResponse()
    {
        $cacheKey = 'foo-bar-123';

        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"expires_in": "3600"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $cacheAdapter = \Mockery::mock(CacheInterface::class);
        $cacheAdapter->shouldReceive('has')
            ->once()
            ->withAnyArgs()
            ->andReturn(false);

        $cacheAdapter->shouldReceive('set')
            ->once()
            ->with($cacheKey, ['expires_in' => 3600], 60)
            ->andReturn(true);

        $this->registerCacheAdapter($cacheAdapter);

        $request = \Mockery::mock(AbstractHasCacheTtlInResponse::class, [$apiClient, []])->makePartial();
        $request->setCacheKey($cacheKey);
        $request->setCacheTtlResponseField('expires_in');

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $request->send();
        $this->assertEquals($cacheKey, $request->getCacheableKey());
    }
}
