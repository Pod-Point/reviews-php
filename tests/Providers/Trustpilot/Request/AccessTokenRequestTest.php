<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot\Request;

use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;
use PodPoint\Reviews\Tests\TestCase;

class AccessTokenRequestTest extends TestCase
{
    /**
     * Request required fields.
     *
     * @var string[]
     */
    protected $requiredFields;

    /**
     * Request options.
     *
     * @var string[]
     */
    protected $options;

    /**
     * Preparing test properties.
     */
    protected function setUp(): void
    {
        $this->requiredFields = [
            'apiKey',
            'apiSecret',
            'username',
            'password'
        ];

        $this->options = [
            'apiKey' => 'api-key',
            'apiSecret' => 'api-secret-123',
            'username' => 'api-user',
            'password' => 'api-password',
        ];
    }

    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new AccessTokenRequest($mockedApiClient, $this->options);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());
        $this->assertEquals($this->options, $request->getOptions());
    }

    /**
     * Making sure the required fields returns the right required fields.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testRequiredFields()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new AccessTokenRequest($mockedApiClient, $this->options);

        $this->assertEquals($this->requiredFields, $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetRequest()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new AccessTokenRequest($mockedApiClient, $this->options);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.trustpilot.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/oauth/oauth-business-users-for-applications/accesstoken', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testSend()
    {
        $responseBody = '{"access_token": "jh87rdu6tuytig8o79p80ui0","expires_in": "36000","refresh_token": "u89y7ot6i5u64y5eu6i7t8oysadsd"}';

        $response = $this->getMockedResponse($responseBody);
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new AccessTokenRequest($mockedApiClient, $this->options);

        $accessToken = $request->send();

        $this->assertInstanceOf(AccessToken::class, $accessToken);
    }
}
