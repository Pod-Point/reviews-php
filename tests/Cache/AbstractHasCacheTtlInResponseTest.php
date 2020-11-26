<?php

namespace PodPoint\Reviews\Tests\Cache;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\Cache\AbstractHasCacheTtlInResponse;
use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Tests\TestCase;
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
     * Making sure that the expires_in access token
     */
    public function testGetCacheableTtlFromResponse()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"sample": "json_content"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $request = \Mockery::mock(AbstractHasCacheTtlInResponse::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $cacheKey = sha1(get_class($request));

        $this->assertEquals($cacheKey, $request->getCacheableKey());
    }
}
