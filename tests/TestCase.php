<?php

namespace PodPoint\Reviews\Tests;

use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $provider
     */
    public function mockReviewProviderFactory(string $provider): void
    {
        Mockery::mock('alias:PodPoint\\Reviews\\Providers\\' . $provider . '\\Factory', 'PodPoint\\Reviews\\ReviewsServiceInterface');
    }
}
