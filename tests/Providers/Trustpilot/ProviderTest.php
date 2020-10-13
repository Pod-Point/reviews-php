<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use PodPoint\Reviews\Providers\Trustpilot\Provider;
use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;
use PodPoint\Reviews\Tests\TestCase;

class ProviderTest extends TestCase
{
    /**
     * Trustpilot configurations.
     *
     * @var string[]
     */
    protected $config;

    /**
     * Instance of an Provider.
     *
     * @var Provider
     */
    protected $provider;

    /**
     * Setting up a test instance of provider.
     */
    protected function setUp(): void
    {
        $this->config = [
            'username' => 'TEST_TRUSTPILOT_USERNAME',
            'password' => 'TEST_TRUSTPILOT_PASSWORD',
            'client_secret' => 'TEST_TRUSTPILOT_CLIENT_SECRET',
            'client_id' => 'TEST_TRUSTPILOT_CLIENT_ID',
            'business_unit_id' => 'TEST_TRUSTPILOT_BUSINESS_ID',
        ];

        $this->provider = new Provider($this->config);
    }

    /**
     * Making sure the properties are set and implementing ProviderInterface.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ProviderInterface::class, $this->provider);
        $this->assertEquals($this->config, $this->provider->getConfig());
    }

    /**
     * The merchant method should return an instance of ActionsInterface.
     */
    public function testMerchant()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->provider->merchant());
    }

    /**
     * The product method should return an instance of ActionsInterface.
     */
    public function testProduct()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->provider->product());
    }
}
