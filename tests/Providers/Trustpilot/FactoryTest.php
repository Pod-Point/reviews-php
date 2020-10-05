<?php


namespace PodPoint\Reviews\Tests\Providers\Trustpilot;


use PodPoint\Reviews\Providers\Trustpilot\Factory;
use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;
use PodPoint\Reviews\Tests\TestCase;

class FactoryTest extends TestCase
{
    /**
     * Trustpilot configurations.
     *
     * @var string[]
     */
    protected $config;

    /**
     * Instance of an factory.
     *
     * @var Factory
     */
    protected $factory;

    protected function setUp()
    {
        $this->config = [
            'username' => 'TEST_TRUSTPILOT_USERNAME',
            'password' => 'TEST_TRUSTPILOT_PASSWORD',
            'api_secret' => 'TEST_TRUSTPILOT_SECRET_KEY',
            'api_key' => 'TEST_TRUSTPILOT_API_KEY',
            'business_id' => 'TEST_TRUSTPILOT_BUSINESS_ID',
        ];

        $this->factory = new Factory($this->config);
    }

    /**
     * Making sure the properties are set and implementing ReviewsServiceInterface.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ReviewsServiceInterface::class, $this->factory);
        $this->assertEquals($this->config, $this->factory->getConfig());
    }

    /**
     * The service method should return an instance of ActionsInterface.
     */
    public function testService()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->factory->service());
    }

    /**
     * The product method should return an instance of ActionsInterface.
     */
    public function testProduct()
    {
        $this->assertInstanceOf(ActionsInterface::class, $this->factory->product());
    }
}
