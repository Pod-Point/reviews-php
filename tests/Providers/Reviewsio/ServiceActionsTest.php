<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\ReviewsIo\MerchantActions;
use PodPoint\Reviews\Tests\TestCase;

class MerchantActionsTest extends TestCase
{
    /**
     * Constructor should be instance of APiClientInterface and it should assign to apiClient property.
     */
    public function testConstruct()
    {
        $action = new Mocked_MerchantActions($this->getMockedApiClient());

        $this->assertInstanceOf(ActionsInterface::class, $action);
        $this->assertInstanceOf(ApiClientInterface::class, $action->getApiClient());
    }

    /**
     *  Making sure business id is setters and getters setting property as expected.
     */
    public function testStore()
    {
        $action = new MerchantActions($this->getMockedApiClient());

        $store = 'foo-bar-123';
        $action->setStore($store);

        $this->assertEquals('foo-bar-123', $action->getStore());
    }

    /**
     * Making sure the invite method to make sure it returns the response as expected.
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

        $response = $this->getMockedResponse('{"status": "200", "message": "accepted"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient);
        $action->setStore('store-number-123');

        $inviteResponse = $action->invite($options);

        $expectedResult = [
            "status" => "200",
            "message" => "accepted",
        ];

        $this->assertEquals($expectedResult, $inviteResponse);
    }

    /**
     * Making sure the getReviews method to make sure it returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetReviews()
    {
        $response = $this->getMockedResponse('{"status": "200", "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient);
        $action->setStore('store-number-123');

        $getReviewsResponse = $action->getReviews([]);

        $expectedResult = [
            "status" => "200",
            "message" => "successful",
        ];

        $this->assertEquals($expectedResult, $getReviewsResponse);
    }

    /**
     * Making sure the findReview method to make sure it returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testFindReview()
    {
        $reviewId = 'review-id-123';

        $response = $this->getMockedResponse('{"status": "200", "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient);
        $action->setStore('store-number-123');

        $findReviewResponse = $action->findReview($reviewId);

        $expectedResult = [
            "status" => "200",
            "message" => "successful",
        ];

        $this->assertEquals($expectedResult, $findReviewResponse);
    }
}

class Mocked_MerchantActions extends MerchantActions
{
    /**
     * @return \PodPoint\Reviews\Providers\ReviewsIo\ReviewsCoUkApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * @return string
     */
    public function getStore(): string
    {
        return $this->store;
    }
}
