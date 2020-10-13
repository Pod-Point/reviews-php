<?php

namespace PodPoint\Reviews\Tests\Request;

use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Tests\TestCase;

class BaseRequestTest extends TestCase
{
    /**
     * Instance of a mocked abstract BaseRequest.
     *
     * @var \Mockery\Expectation|\Mockery\ExpectationInterface|\Mockery\HigherOrderMessage
     */
    protected $mockedRequest;

    /**
     * Instance of mocked AbstractApiClient.
     *
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|\PodPoint\Reviews\AbstractApiClient
     */
    protected $mockedApiClient;

    /**
     * Setting up test instances.
     */
    protected function setUp(): void
    {
        $this->mockedApiClient = $this->getMockedApiClient();
        $this->mockedRequest = $this->getMockedBaseRequest($this->mockedApiClient, ['foo-required' => 'bar'], ['foo-required']);
    }

    /**
     * Test construct to make sure properties are set.
     */
    public function testConstruct()
    {
        $this->assertEquals(['foo-required' => 'bar'], $this->mockedRequest->getOptions());
    }

    /**
     * Making sure validate returns true when
     *
     * @throws ValidationException
     */
    public function testGivenValidOptionsValidateShouldReturnTrue()
    {
        $this->assertTrue($this->mockedRequest->validate());
    }

    /**
     * Making sure validate throws ValidationException when invalid options given.
     */
    public function testGivenInvalidOptionsValidateShouldThrowException()
    {
        $this->expectException(ValidationException::class);

        $request = $this->getMockedBaseRequest(
            $this->mockedApiClient,
            [
                'invalid' => 'test-user-1',
                'foo' => 'testPassword1',
            ],
            [
                'username',
                'password',
                'apiKey',
            ]
        );

        $request->validate();
    }
}
