<?php

namespace PodPoint\Reviews\Tests\Providers\Reviewsio;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\Providers\Trustpilot\ProductActions;
use PodPoint\Reviews\Tests\TestCase;

/**
 * Class ProductActionsTest
 * @package PodPoint\Reviews\Tests\Providers\Reviewsio
 */
class ProductActionsTest extends TestCase
{
    /**
     * Making sure the actions are setting configs and client on construct.
     */
    public function testConstruct()
    {
        $apiClient = $this->getMockedApiClient();
        $productAction = new ProductActions($apiClient);

        $this->assertInstanceOf(ActionsInterface::class, $productAction);
    }
}
