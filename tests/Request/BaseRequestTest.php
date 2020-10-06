<?php

namespace PodPoint\Reviews\Tests\Request;

use PodPoint\Reviews\Exceptions\ValidationException;
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
        $request = $this->getMockedBaseRequest($mockedApiClient, $options);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());
        $this->assertEquals($options, $request->getOptions());
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
        $request = $this->getMockedBaseRequest($mockedApiClient, $options, $requiredFields);

        $this->assertTrue($request->validate());
    }

    /**
     * Making sure validate returns true when
     */
    public function testGivenInvalidOptionsValidateShouldReturnTrue()
    {
        $this->expectException(ValidationException::class);

        $options = [
            'invalid' => 'test-user-1',
            'foo' => 'testPassword1',
        ];

        $requiredFields = [
            'username', 'password', 'apiKey'
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $request = $this->getMockedBaseRequest($mockedApiClient, $options, $requiredFields);

        $request->validate();
    }
}
