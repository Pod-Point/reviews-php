<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use PodPoint\Reviews\Providers\Trustpilot\ServiceActions;
use PodPoint\Reviews\Providers\Trustpilot\TrustpilotApiClient;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class ServiceActionsTest
 * @package PodPoint\Reviews\Tests\Providers\Trustpilot
 */
class ServiceActionsTest extends TestCase
{
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
    public function invite()
    {
        /*TODO*/
        $options = [
            'business_id' => 'foo-bar-321'
        ];

        $apiClient = new TrustpilotApiClient();

        $client = $this->getMockedApiClient();
        $action = new ServiceActions($apiClient);

        $inviteResponse = $action->invite($options);
    }
}
