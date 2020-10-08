<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsIo;

use PodPoint\Reviews\Providers\ReviewsIo\Provider;
use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;
use PodPoint\Reviews\Tests\TestCase;

class ProviderTest extends TestCase
{
    /**
     * Instance of an Provider.
     *
     * @var Provider
     */
    protected $provider;

    /**
     * Setting up test instance of provider.
     */
    protected function setUp(): void
    {
        $this->provider = new Provider([
            'api_key' => 'TEST_REVIEWSIO_API_KEY',
            'store' => 'store-id-321'
        ]);
    }

    /**
     * Making sure the properties are set and implementing ProviderInterface.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ProviderInterface::class, $this->provider);
        $this->assertEquals([
            'api_key' => 'TEST_REVIEWSIO_API_KEY',
            'store' => 'store-id-321'
        ], $this->provider->getConfig());
    }

    /**
     * The service method should return an instance of ActionsInterface.
     */
    public function testService()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->provider->service());
    }

    /**
     * The product method should return an instance of ActionsInterface.
     */
    public function testProduct()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->provider->product());
    }
}
