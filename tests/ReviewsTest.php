<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\Exceptions\ProviderConfigNotFoundException;
use PodPoint\Reviews\Exceptions\ProviderNotFoundException;
use PodPoint\Reviews\Reviews;
use PodPoint\Reviews\ProviderInterface;

class ReviewsTest extends TestCase
{
    /**
     * review-providers.php config sample, needed to construct manager.
     *
     * @var \string[][]
     */
    protected $config;

    /**
     * Setting up test configs.
     */
    protected function setUp(): void
    {
        $this->mockReviewProviderProvider('Foo');

        $this->config = [
            'foo' => [
                'some_key' => 'API_KEY',
                'other_key' => 'SECRET_KEY',
            ],
        ];
    }

    /**
     * Making sure the manager instance set the configuration on construct call.
     */
    public function testConstruct()
    {
        $reviews = new Reviews($this->config);

        $this->assertEquals($this->config, $reviews->getConfig());
    }

    /**
     * The with provider should should return an instance of ProviderInterface.
     * @throws ProviderNotFoundException|ProviderConfigNotFoundException
     */
    public function testWithProvider()
    {
        $reviews = new Reviews($this->config);

        $this->assertInstanceOf('PodPoint\\Reviews\\Providers\\Foo\\Provider', $reviews->withProvider('foo'));
    }

    /**
     * The with provider should should return an instance of ProviderInterface.
     */
    public function testWithProviderInvalidProvider()
    {
        $this->expectException(ProviderNotFoundException::class);
        $reviews = new Reviews($this->config);

        $this->assertInstanceOf('PodPoint\\Reviews\\Providers\\Foo\\Provider', $reviews->withProvider('invalid'));
    }

    /**
     * Should return existing provider config.
     * @throws ProviderConfigNotFoundException
     */
    public function testGetProviderConfig()
    {
        $reviews = new Reviews($this->config);

        $expectedConfig = [
            'some_key' => 'API_KEY',
            'other_key' => 'SECRET_KEY',
        ];

        $this->assertEquals($expectedConfig, $reviews->getProviderConfig('foo'));
    }

    /**
     * Should throw ProviderConfigNotFoundException exception for invalid provider.
     */
    public function testInvalidGetProviderConfig()
    {
        $this->expectException(ProviderConfigNotFoundException::class);

        $reviews = new Reviews($this->config);
        $reviews->getProviderConfig('bar');
    }

    /**
     * Test that getProviderClassName function returns the correct classname given a provider name.
     */
    public function testGetProviderClassName()
    {
        $reviews = new Reviews($this->config);
        $actualClassName = $reviews->getProviderClassName('reviews_io');
        $expectedClassName = 'PodPoint\\Reviews\\Providers\\ReviewsIo\\Provider';

        $this->assertEquals($expectedClassName, $actualClassName);
    }

    /**
     * The magic method __call should return provider.
     */
    public function test__callMagicMethod()
    {
        $reviews = new Reviews($this->config);
        $foo = $reviews->foo();

        $this->assertInstanceOf(ProviderInterface::class, $foo);
    }
}
