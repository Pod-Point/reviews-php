<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo\Request\Merchant;

use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\GetMerchantReviews;
use PodPoint\Reviews\Tests\TestCase;

class GetMerchantReviewsTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new GetMerchantReviews($mockedApiClient, [
            'store' => 'store-id-321',
        ]);

        $this->assertEquals($mockedApiClient, $request->getApiClient());
        $this->assertEquals([
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
        $request = new GetMerchantReviews($mockedApiClient, [
            'store' => 'store-id-321',
        ]);

        $this->assertEquals(['store'], $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetRequest()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new GetMerchantReviews($mockedApiClient, [
            'store' => 'store-id-321',
        ]);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('/merchant/reviews', $request->getUri()->getPath());
        $this->assertEquals('store=store-id-321', $request->getUri()->getQuery());
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

        $request = new GetMerchantReviews($mockedApiClient, [
            'store' => 'store-id-321',
        ]);

        $this->assertEquals([
            'status' => 'OK',
            'message' => 'successful',
        ], $request->send());
    }
}
