<?php

namespace PodPoint\Reviews\Tests\Request;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Request\BaseRequest;
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

        $this->mockedRequest = $this->getMockedBaseRequest($this->mockedApiClient, [
            'username' => 'sample-user',
            'password' => 'sample-pa55w0rd',
            'apiKey' => 'sample-api-key',
        ], [
            'username',
            'password',
            'apiKey',
        ]);
    }

    /**
     * Test construct to make sure properties are set.
     */
    public function testConstruct()
    {
        $this->mockedRequest = $this->getMockedBaseRequest($this->mockedApiClient, [
            'username' => 'sample-user',
            'password' => 'sample-pa55w0rd',
            'apiKey' => 'sample-api-key',
        ], [
            'username',
            'password',
            'apiKey',
        ]);

        $this->assertEquals($this->mockedApiClient, $this->mockedRequest->getHttpClient());
    }

    /**
     * Making sure validate returns true when
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

        $options = [
            'invalid' => 'test-user-1',
            'foo' => 'testPassword1',
        ];

        $request = new class($this->mockedApiClient, $options) extends BaseRequest {
            public function requiredFields(): array
            {
                return [
                    'username',
                    'password',
                    'apiKey',
                ];
            }

            public function getRequest(): Request
            {
                //
            }

            public function send()
            {
                //
            }
        };

        $request->validate();
    }
}
