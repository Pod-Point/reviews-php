<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot\Request;

use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\InviteRequest;
use PodPoint\Reviews\Tests\TestCase;

class InviteRequestTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $options = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
            'businessUnitId' => 'store-321',
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $request = new InviteRequest($mockedApiClient, $options);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());
        $this->assertEquals($options, $request->getOptions());
    }

    /**
     * Making sure the required fields returns the right required fields.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testRequiredFields()
    {
        $options = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $request = new InviteRequest($mockedApiClient, $options);

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
        $options = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
            'businessUnitId' => 'store-321',
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new InviteRequest($mockedApiClient, $options);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('invitations-api.trustpilot.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/private/business-units/store-321/email-invitations', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     */
    public function testSend()
    {
        $options = [
            'referenceNumber' => 'reference-123',
            'consumerEmail' => 'customer@example.com',
            'consumerName' => 'John Smith',
            'businessUnitId' => 'store-321',
        ];

        $response = $this->getMockedResponse('{}');
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new InviteRequest($mockedApiClient, $options);

        $this->assertEquals([], $request->send());
    }
}
