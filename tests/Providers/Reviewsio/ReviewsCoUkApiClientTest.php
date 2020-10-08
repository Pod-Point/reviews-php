<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\ReviewsIo\ReviewsCoUkApiClient;
use PodPoint\Reviews\Tests\TestCase;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class ReviewsCoUkApiClientTest extends TestCase
{
    /**
     * Instance of a ReviewsCoUkApiClient.
     *
     * @var ReviewsCoUkApiClient
     */
    protected $apiClient;

    /**
     * Setting up a test instance of API client.
     */
    protected function setUp(): void
    {
        $this->apiClient = new ReviewsCoUkApiClient('api-key-123');
    }

    /**
     * Making sure the Reviewsio Client constructor is setting properties and constructs instance of a valid http client.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ApiClientInterface::class, $this->apiClient);

        $this->assertEquals('api-key-123', $this->apiClient->getApiKey());
    }


    /**
     * The sendRequest method should attach authorization header to request.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendRequestWithAuthentication()
    {
        $mockedResponse = $this->getMockedResponse('{}');

        $mockedHttpClient = Mockery::mock(ClientInterface::class);

        $mockedHttpClient->shouldReceive('send')
            ->withAnyArgs()
            ->andReturn($mockedResponse);

        $this->apiClient->setHttpClient($mockedHttpClient);

        $mockedRequest = Mockery::mock(Request::class, ["GET", "https://example.com"])->makePartial();
        $mockedRequest->shouldReceive('withHeader')
            ->once()
            ->withArgs(['apikey', 'api-key-123'])
            ->andReturnSelf();

        $response = $this->apiClient->sendRequest($mockedRequest, true);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * The sendRequest method should return response.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendRequestWithoutAuthentication()
    {
        $mockedRequest = Mockery::mock(Request::class, ["GET", "https://example.com"])->makePartial();

        $response = $this->apiClient->sendRequest($mockedRequest, false);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
