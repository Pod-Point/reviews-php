<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\Trustpilot\ServiceActions;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class ServiceActionsTest
 * @package PodPoint\Reviews\Tests\Providers\Trustpilot
 */
class ServiceActionsTest extends TestCase
{

    /**
     * Constructor should be instance of APiClientInterface and it should assign to apiClient property.
     */
    public function testConstruct()
    {
        $action = new Mocked_ServiceActions($this->getMockedApiClient());

        $this->assertInstanceOf(ActionsInterface::class, $action);
        $this->assertInstanceOf(ApiClientInterface::class, $action->getApiClient());
    }

    /**
     *  Making sure business id is setters and getters setting property as expected.
     */
    public function testBusinessUnitId()
    {
        $action = new ServiceActions($this->getMockedApiClient());

        $businessId = 'foo-bar-123';
        $action->setBusinessUnitId($businessId);

        $this->assertEquals('foo-bar-123', $action->getBusinessUnitId());
    }

    /**
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testInvite()
    {
        $options = [
            'referenceNumber',
            'consumerEmail',
            'consumerName'
        ];

        $response = $this->getMockedResponse('{"status": "200", "message": "accepted"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new ServiceActions($apiClient);
        $action->setBusinessUnitId('foo-bar-321');

        $inviteResponse = $action->invite($options);

        $expectedResult = [
            "status" => "200",
            "message" => "accepted",
        ];

        $this->assertEquals($expectedResult, $inviteResponse);
    }

    /**
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetReviews()
    {
        $options = [];

        $response = $this->getMockedResponse('{"status": "200", "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new ServiceActions($apiClient);
        $action->setBusinessUnitId('foo-bar-321');

        $getReviewsResponse = $action->getReviews($options);

        $expectedResult = [
            "status" => "200",
            "message" => "successful",
        ];

        $this->assertEquals($expectedResult, $getReviewsResponse);
    }

    /**
     * @return array|mixed
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testFindReview()
    {
        $reviewId = 'review-id-123';

        $response = $this->getMockedResponse('{"status": "200", "message": "successful"}');
        $apiClient = $this->getMockedApiClient();
        $apiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $action = new ServiceActions($apiClient);
        $action->setBusinessUnitId('foo-bar-321');

        $findReviewResponse = $action->findReview($reviewId);

        $expectedResult = [
            "status" => "200",
            "message" => "successful",
        ];

        $this->assertEquals($expectedResult, $findReviewResponse);
    }
}

class Mocked_ServiceActions extends ServiceActions
{
    public function getApiClient()
    {
        return $this->apiClient;
    }
}
