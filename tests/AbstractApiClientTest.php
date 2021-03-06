<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\ApiClientInterface;

class AbstractApiClientTest extends TestCase
{
    /**
     * Making sure client is set when instance is  constructed.
     */
    public function testConstruct()
    {
        $apiClient = $this->getMockedApiClient();

        $this->assertInstanceOf(ApiClientInterface::class, $apiClient);
    }

    /**
     * Making sure that getResponse converts json response into an array.
     */
    public function testGetResponseJson()
    {
        $apiClient = $this->getMockedApiClient();

        $mockedResponse = $this->getMockedResponse('{"foo": "bar"}');
        $response = $apiClient->getResponseJson($mockedResponse);

        $this->assertEquals([
            'foo' => 'bar'
        ], $response);
    }

    /**
     * Making sure that getResponse converts json response into an array and not throw exception when the response
     * body is empty.
     */
    public function testGetResponseJsonWithEmptyBody()
    {
        $apiClient = $this->getMockedApiClient();

        $mockedResponse = $this->getMockedResponse('');
        $response = $apiClient->getResponseJson($mockedResponse);

        $this->assertEquals([], $response);
    }
}
