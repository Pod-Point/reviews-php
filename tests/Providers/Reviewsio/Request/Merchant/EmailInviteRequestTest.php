<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo\Request\Merchant;

use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\EmailInviteRequest;
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

        $this->assertEquals($mockedApiClient, $request->getApiClient());
        $this->assertEquals([
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-id-123',
            'store' => 'store-id-321',
        ], $request->getOptions());
    }

    /**
     * Making sure the required fields returns the right required fields.
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
     *
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

        $this->assertEquals('/merchant/invitation', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     *
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
