<?php

namespace PodPoint\Reviews\Tests\Providers\Reviewsio\Request\Service;

use PodPoint\Reviews\Providers\Reviewsio\Request\Service\EmailInviteRequest;
use PodPoint\Reviews\Tests\TestCase;

class EmailInviteRequestTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new EmailInviteRequest($mockedApiClient, [
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ]);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());
        $this->assertEquals([
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ], $request->getOptions());
    }

    /**
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testRequiredFields()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new EmailInviteRequest($mockedApiClient, [
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ]);

        $this->assertEquals([
            'name',
            'email',
            'order_id',
            'store',
        ], $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetRequest()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new EmailInviteRequest($mockedApiClient, [
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ]);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.reviews.co.uk', $request->getUri()->getHost());
        $this->assertEquals('/merchant/invitation', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testSend()
    {
        $response = $this->getMockedResponse('{"status": "OK", "message": "successful"}');
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new EmailInviteRequest($mockedApiClient, [
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ]);

        $this->assertEquals([
            'status' => 'OK',
            'message' => 'successful',
        ], $request->send());
    }
}
