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

    protected function setUp()
    {
        $this->config = [
            'username' => 'TEST_TRUSTPILOT_USERNAME',
            'password' => 'TEST_TRUSTPILOT_PASSWORD',
            'api_secret' => 'TEST_TRUSTPILOT_SECRET_KEY',
            'api_key' => 'TEST_TRUSTPILOT_API_KEY',
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
