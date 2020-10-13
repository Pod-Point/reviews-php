<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\Trustpilot\MerchantActions;
use PodPoint\Reviews\Tests\TestCase;

class MerchantActionsTest extends TestCase
{
    /**
     * Constructor should be instance of APiClientInterface and it should assign to apiClient property.
     */
    public function testConstruct()
    {
        $action = new Mocked_MerchantActions($this->getMockedApiClient(), []);

        $this->assertInstanceOf(ActionsInterface::class, $action);
        $this->assertInstanceOf(ApiClientInterface::class, $action->getApiClient());
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
            'referenceNumber' => 'reference-number-321',
            'consumerEmail' => 'customer@email.com',
            'consumerName' => 'Customer Name',
            'preferredSendTime' => '2013-09-07T13:37:00',
        ];

        $response = $this->getMockedResponse('');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'business_unit_id' => 'foo-bar-321',
            'invite_redirect_uri' => 'http://example.com',
            'invite_reply_to_email' => 'no-reply@example.com',
        ]);

        $inviteResponse = $action->invite($options);

        $this->assertEquals([], $inviteResponse);
    }

    /**
     * Making sure the getReviews method to make sure it returns the response as expected.
     *
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetReviews()
    {
        $options = [];

        $response = $this->getMockedResponse('{"data": [], "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'business_unit_id' => 'foo-bar-321',
            'invite_redirect_uri' => 'http://example.com',
            'invite_reply_to_email' => 'no-reply@example.com',
        ]);

        $getReviewsResponse = $action->getReviews($options);

        $expectedResult = [
            "data" => [],
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

        $response = $this->getMockedResponse('{"data": [], "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new MerchantActions($apiClient, [
            'business_unit_id' => 'foo-bar-321',
            'invite_redirect_uri' => 'http://example.com',
            'invite_reply_to_email' => 'no-reply@example.com',
        ]);

        $findReviewResponse = $action->findReview($reviewId);

        $expectedResult = [
            "data" => [],
            "message" => "successful",
        ];

        $this->assertEquals($expectedResult, $findReviewResponse);
    }
}

class Mocked_MerchantActions extends MerchantActions
{
    public function getApiClient()
    {
        return $this->apiClient;
    }
}
