<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\Trustpilot\TrustpilotApiClient;
use PodPoint\Reviews\Tests\TestCase;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class TrustpilotApiClientTest extends TestCase
{

    protected $apiClient;

    /**
     * Setting up test instance.
     */
    protected function setUp()
    {
        $apiKey = 'api-key-123';
        $secretKey = 'api-secret-key-123';
        $username = 'api-username';
        $password = 'api-password';

        $this->apiClient = new TrustpilotApiClient(
            $apiKey, $secretKey, $username, $password
        );
    }

    /**
     * Making sure the Trustpilot constructor is setting properties and constructs instance of a valid http client.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ApiClientInterface::class, $this->apiClient);

        $this->assertEquals('api-key-123', $this->apiClient->getApiKey());
        $this->assertEquals('api-secret-key-123', $this->apiClient->getSecretKey());
        $this->assertEquals('api-username', $this->apiClient->getUsername());
        $this->assertEquals('api-password', $this->apiClient->getPassword());
    }

    /**
     * Making sure access token can be grabbed and returned as AccessToken model.
     */
    public function testGetAccessToken()
    {
        $responseBody = '{"access_token": "ey12easdwrsyeud6if7gohoji8hp97o68fi", "expires_in": "3600","refresh_token": "0/koiouliykgutjyhethrfjyguktrdyfS3"}';
        $mockedResponse = $this->getMockedResponse($responseBody);

        $mockedHttpClient = Mockery::mock(ClientInterface::class);

        $mockedHttpClient->shouldReceive('send')
            ->withAnyArgs()
            ->andReturn($mockedResponse);

        $this->apiClient->setHttpClient($mockedHttpClient);

        $this->assertInstanceOf(AccessToken::class, $this->apiClient->getAccessToken());
    }

    /**
     * The sendRequest method should attach authorization header to request.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendRequestWithAuthentication()
    {
        $responseBody = '{"access_token": "ey12easdwrsyeud6if7gohoji8hp97o68fi", "expires_in": "3600","refresh_token": "0/koiouliykgutjyhethrfjyguktrdyfS3"}';
        $mockedResponse = $this->getMockedResponse($responseBody);

        $mockedHttpClient = Mockery::mock(ClientInterface::class);

        $mockedHttpClient->shouldReceive('send')
            ->withAnyArgs()
            ->andReturn($mockedResponse);

        $this->apiClient->setHttpClient($mockedHttpClient);

        $mockedRequest = Mockery::mock(Request::class, ["GET", "https://example.com"])->makePartial();
        $mockedRequest->shouldReceive('withHeader')
            ->once()
            ->withArgs(['authorization', 'Bearer ey12easdwrsyeud6if7gohoji8hp97o68fi'])
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
