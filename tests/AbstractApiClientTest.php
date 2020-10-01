<?php

namespace PodPoint\Reviews\Tests;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class AbstractApiClientTest
 * @package PodPoint\Reviews\Tests
 */
class AbstractApiClientTest extends TestCase
{

    /**
     * Making suer client is set when instance is  constructed.
     */
    public function testConstruct()
    {
        $apiClient = new MockedApiClient();

        $this->assertInstanceOf(ClientInterface::class, $apiClient->getHttpClient());
    }

    /**
     * Making sure that getResponse converts json response into an array.
     */
    public function testGetResponseJson()
    {
        $apiClient = new MockedApiClient();

        $mockedResponse = $this->getMockedResponse('{"foo": "bar"}');

        $response = $apiClient->getResponseJson($mockedResponse);

        $this->assertEquals([
            'foo' => 'bar'
        ], $response);
    }
}

/**
 * Class MockedApiClient
 * @package PodPoint\Reviews\Tests
 */
class MockedApiClient extends AbstractApiClient {

    public function sendRequest(Request $request, bool $withAuthentication)
    {
        // TODO: Implement validateAndSend() method.
    }
}
