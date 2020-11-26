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
     * Making sure that the expires_in access token
     */
    public function testGetCacheableTtlFromResponse()
    {
        $this->httpClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockedGuzzleRequest)
            ->andReturn(new Response(200, [], '{"expires_in": "36000"}'));

        $apiClient = $this->getMockedApiClient($this->httpClient);
        $apiClient->shouldReceive('addAuthenticationHeader');

        $cacheAdapter = \Mockery::mock(CacheInterface::class);
        $cacheAdapter->shouldReceive('has')
            ->once()
            ->withAnyArgs()
            ->andReturn(false);

        $cacheAdapter->shouldReceive('set')
            ->once()
            ->withAnyArgs()
            ->andReturn(true);

        $this->registerCacheAdapter($cacheAdapter);

        $request = \Mockery::mock(AbstractHasCacheTtlInResponse::class, [$apiClient, []])->makePartial();

        $request->shouldReceive('getRequest')
            ->withNoArgs()
            ->andReturn($this->mockedGuzzleRequest);

        $request->shouldReceive('convertFromSecondsToMinutes')
            ->once()
            ->with(3600)
            ->andReturn(60);

        $request->send();
    }


    /**
     * Data provider for testConvertFromSecondsToMinutes.
     */
    public function convertFromSecondsToMinutesDataProvider()
    {
        return [
            'Should pass: should convert seconds into minutes' => [
                $value = 6720,
                $expected = 112,
            ],
            'Should pass: should return 0 when seconds is negative value' => [
                $value = -100,
                $expected = 0,
            ],
            'Should pass: should return 0 when seconds is 0' => [
                $value = 0,
                $expected = 0,
            ],
        ];
    }

    /**
     * Making sure seconds are converted into minutes.
     *
     * @dataProvider convertFromSecondsToMinutesDataProvider
     */
    public function testConvertFromSecondsToMinutes($value, $expected)
    {
        $actual = AbstractHasCacheTtlInResponse::convertFromSecondsToMinutes($value);

        $this->assertEquals($expected, $actual);
    }
}
