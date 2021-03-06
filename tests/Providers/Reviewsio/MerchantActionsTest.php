<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\ReviewsIo\MerchantActions;
use PodPoint\Reviews\Tests\TestCase;

class MerchantActionsTest extends TestCase
{
    /**
     * Constructor should be instance of APIClientInterface and it should assign to apiClient property.
     */
    public function testConstruct()
    {
        $action = new Mocked_MerchantActions($this->getMockedApiClient(), []);

        $this->assertInstanceOf(ActionsInterface::class, $action);
        $this->assertInstanceOf(ApiClientInterface::class, $action->getApiClient());
    }

    /**
     * Making sure the invite method returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testInvite()
    {
        $options = [
            'name' => 'Customer Name',
            'email' => 'customer@email.com',
            'order_id' => 'order-number-321',
        ];

        $response = $this->getMockedResponse('{"data": [], "message": "accepted"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'store' => 'store-number-123'
        ]);

        $inviteResponse = $action->invite($options);

        $expectedResult = [
            'data' => [],
            'message' => 'accepted',
        ];

        $this->assertEquals($expectedResult, $inviteResponse);
    }

    /**
     * Making sure the getReviews method returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetReviews()
    {
        $response = $this->getMockedResponse('{"data": [], "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'store' => 'store-number-123'
        ]);

        $getReviewsResponse = $action->getReviews([]);

        $expectedResult = [
            'data' => [],
            'message' => 'successful',
        ];

        $this->assertEquals($expectedResult, $getReviewsResponse);
    }

    /**
     * Making sure the findReview method returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testFindReview()
    {
        $reviewId = 'review-id-123';

        $response = $this->getMockedResponse('{"data": [], "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'store' => 'store-number-123'
        ]);

        $findReviewResponse = $action->findReview($reviewId);

        $expectedResult = [
            'data' => [],
            'message' => 'successful',
        ];

        $this->assertEquals($expectedResult, $findReviewResponse);
    }
}

class Mocked_MerchantActions extends MerchantActions
{
    /**
     * @return \PodPoint\Reviews\Providers\ReviewsIo\ApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }
}
