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
     * @var BaseRequest|__anonymous@455
     */
    protected $request;

    /**
     * Instance of mocked AbstractApiClient.
     *
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|\PodPoint\Reviews\AbstractApiClient
     */
    protected $mockedApiClient;

    protected function setUp()
    {
        $this->mockedApiClient = $this->getMockedApiClient();

        $this->request = new class($this->mockedApiClient, ['foo-required' => 'bar']) extends BaseRequest {

            public function requiredFields(): array
            {
                return ['foo-required'];
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
    }

    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $this->assertEquals($this->mockedApiClient, $this->request->getHttpClient());
        $this->assertEquals(['foo-required' => 'bar'], $this->request->getOptions());
    }

    /**
     * Making sure validate returns true when
     */
    public function testGivenValidOptionsValidateShouldReturnTrue()
    {
        $this->assertTrue($this->request->validate());
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
