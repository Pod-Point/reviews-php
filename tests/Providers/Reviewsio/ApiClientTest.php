<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\ReviewsIo\ApiClient;
use PodPoint\Reviews\Tests\TestCase;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class ApiClientTest extends TestCase
{
    /**
     * Instance of a ApiClient.
     *
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * Setting up a test instance of API client.
     */
    protected function setUp(): void
    {
        $this->apiClient = new ApiClient('api-key-123');
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
     * Should add default api request headers without override request headers.
     */
    public function testAddDefaultRequestHeadersToRequest()
    {
        $requestHeaders = [
            'foo' => 'bar',
            'content-type' => 'application/x-foo',
        ];

        $request = new Request('GET', 'http://example.com', $requestHeaders);

        $this->apiClient->addDefaultRequestHeaders($request);

        $expectedHeaders = [
            'Host' => [
                'example.com'
            ],
            'foo' => [
                'bar'
            ],
            'content-type' => [
                'application/x-foo'
            ],
        ];

        $this->assertEquals($expectedHeaders, $request->getHeaders());
    }

    /**
     * Should add default api request header content-type application json.
     */
    public function testAddDefaultRequestHeaders()
    {
        $request = new Request('GET', 'http://example.com');

        $this->apiClient->addDefaultRequestHeaders($request);

        $expectedHeaders = [
            'Host' => [
                'example.com'
            ],
            'content-type' => [
                'application/json'
            ],
        ];

        $this->assertEquals($expectedHeaders, $request->getHeaders());
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
