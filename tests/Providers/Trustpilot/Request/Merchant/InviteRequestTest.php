<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot\Request\Merchant;

use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\InviteRequest;
use PodPoint\Reviews\Tests\TestCase;

class InviteRequestTest extends TestCase
{

    protected $requestOptions;

    public function setUp()
    {
        $this->requestOptions = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
            'businessUnitId' => 'store-321',
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
        $request = new InviteRequest($mockedApiClient, $this->requestOptions);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());

        $expectedOptions = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
            'businessUnitId' => 'store-321',
        ];

        $this->assertEquals($expectedOptions, $request->getOptions());
    }

    /**
     * Making sure the required fields returns the right required fields.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testRequiredFields()
    {

        $mockedApiClient = $this->getMockedApiClient();
        $request = new InviteRequest($mockedApiClient, $this->requestOptions);

        $expectedRequiredFields = [
            'referenceNumber',
            'consumerEmail',
            'consumerName',
        ];

        $this->assertEquals($expectedRequiredFields, $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetRequest()
    {

        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new InviteRequest($mockedApiClient, $this->requestOptions);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('invitations-api.trustpilot.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/private/business-units/store-321/email-invitations', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testSend()
    {
        $response = $this->getMockedResponse('{}');
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new InviteRequest($mockedApiClient, $this->requestOptions);

        $this->assertEquals([], $request->send());
    }
}
