<?php

namespace PodPoint\Reviews\Tests\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Exceptions\UnauthorizedException;
use PodPoint\Reviews\Request\AbstractCacheableRequest;
use PodPoint\Reviews\Tests\TestCase;
use Psr\SimpleCache\CacheInterface;

/**
 * Class AbstractCacheableRequestTest
 */
class AbstractCacheableRequestTest extends TestCase
{
    protected $mockedGuzzleRequest;

    protected $httpClient;

    /**
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
     *
     */
    public function testGetCacheableKey()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"sample": "json_content"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $request = \Mockery::mock(AbstractCacheableRequest::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $cacheKey = sha1(get_class($request));

        $this->assertEquals($cacheKey, $request->getCacheableKey());
    }

    /**
     * @throws UnauthorizedException
     */
    public function testSendWithExistingCache()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"sample": "json_content"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $request = \Mockery::mock(AbstractCacheableRequest::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $cacheKey = sha1(get_class($request));

        $this->cacheAdapter->shouldReceive('has')
            ->once()
            ->with($cacheKey)
            ->andReturnTrue();

        $this->cacheAdapter->shouldReceive('get')
            ->once()
            ->with($cacheKey)
            ->andReturn(['sample' => 'json_content']);

        $actualResponse = $request->send();

        $this->assertEquals(['sample' => 'json_content'], $actualResponse);
    }

    /**
     * Making sure when the cache doesn't exist the response is cached and returned.
     *
     * @throws UnauthorizedException
     */
    public function testSendWithNoCacheHit()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"sample": "json_content"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $request = \Mockery::mock(AbstractCacheableRequest::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $cacheKey = sha1(get_class($request));

        $this->cacheAdapter->shouldReceive('has')
            ->once()
            ->with($cacheKey)
            ->andReturnFalse();

        $this->cacheAdapter
            ->shouldReceive('set')
            ->once()
            ->with($cacheKey, ['sample' => 'json_content'], 3600)
            ->andReturnTrue();

        $actualResponse = $request->send();

        $this->assertEquals(['sample' => 'json_content'], $actualResponse);
    }

    /**
     * Making sure when the authentication for the request fails, it throws UnauthorizedException
     * and no cache is stored.
     */
    public function testSendWithUnauthorizedException()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(401, ['status' => '401 Unauthorized'], '{"message": "Unauthorized!"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $request = \Mockery::mock(AbstractCacheableRequest::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $cacheKey = sha1(get_class($request));

        $this->cacheAdapter->shouldReceive('has')
            ->once()
            ->with($cacheKey)
            ->andReturnFalse();

        $this->cacheAdapter
            ->shouldNotReceive('set');

        // Check if any content is cached.
        $actualResponse = $request->send();
        $this->assertEquals(["message" => "Unauthorized!"], $actualResponse);
    }
}
