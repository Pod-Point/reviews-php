<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\ApiClientInterface;

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
}
