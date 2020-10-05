<?php

namespace PodPoint\Reviews\Tests\Request;

use PodPoint\Reviews\Tests\TestCase;

/**
 * Class BaseRequestTest
 * @package PodPoint\Reviews\Tests\Request
 */
class BaseRequestTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $options = ['foo' => 'bar'];
        $mockedApiClient = $this->getMockedApiClient();
        $mockedBaseRequest = $this->getMockedBaseRequest($mockedApiClient, $options);

        $this->assertEquals($mockedApiClient, $mockedBaseRequest->getHttpClient());
        $this->assertEquals($options, $mockedBaseRequest->getOptions());
    }

    /**
     * Making sure validate returns true when
     */
    public function testGivenValidOptionsValidateShouldReturnTrue()
    {
        $options = [
            'username' => 'test-user-1',
            'password' => 'testPassword1',
            'apiKey' => 'test-api-key'
        ];

        $requiredFields = [
            'username', 'password', 'apiKey'
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $mockedBaseRequest = $this->getMockedBaseRequest($mockedApiClient, $options, $requiredFields);

        $this->assertTrue($mockedBaseRequest->validate());
    }
}
