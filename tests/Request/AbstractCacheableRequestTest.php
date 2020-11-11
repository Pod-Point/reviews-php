<?php

namespace PodPoint\Reviews\Tests\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Request\AbstractCacheableRequest;
use PodPoint\Reviews\Tests\TestCase;
use Psr\SimpleCache\CacheInterface;

/**
 * Class AbstractCacheableRequestTest
 */
class AbstractCacheableRequestTest extends TestCase
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
     * Making sure when the cache key is not set it can auto generate by class name.
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
     * Making sure the send method returns content from cache when cache exists.
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
        $this->expectException(RequestException::class);

        $response = new Response(401, [], '{"reason":"Authentication Failed"}');

        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andThrow(new RequestException(
                'An error was encountered during the on_headers event',
                $this->mockedGuzzleRequest,
                $response
            ));

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
        $this->assertEquals(["reason" => "Authentication Failed"], $actualResponse);
    }
}
