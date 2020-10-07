<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\Exceptions\ProviderConfigNotFoundException;
use PodPoint\Reviews\Exceptions\ProviderNotFoundException;
use PodPoint\Reviews\Manager;

class ManagerTest extends TestCase
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
        $manager = new Manager($this->config);

        $this->assertEquals($this->config, $manager->getConfig());
    }

    /**
     * The with provider should should return an instance of ProviderInterface.
     * @throws ProviderNotFoundException|ProviderConfigNotFoundException
     */
    public function testWithProvider()
    {
        $manager = new Manager($this->config);

        $this->assertInstanceOf('PodPoint\\Reviews\\Providers\\Foo\\Provider', $manager->withProvider('foo'));
    }

    /**
     * The with provider should should return an instance of ProviderInterface.
     */
    public function testWithProviderInvalidProvider()
    {
        $this->expectException(ProviderNotFoundException::class);
        $manager = new Manager($this->config);

        $this->assertInstanceOf('PodPoint\\Reviews\\Providers\\Foo\\Provider', $manager->withProvider('invalid'));
    }

    /**
     * Should return existing provider config.
     * @throws ProviderConfigNotFoundException
     */
    public function testGetProviderConfig()
    {
        $manager = new Manager($this->config);

        $expectedConfig = [
            'some_key' => 'API_KEY',
            'other_key' => 'SECRET_KEY',
        ];

        $this->assertEquals($expectedConfig, $manager->getProviderConfig('foo'));
    }

    /**
     * Should throw ProviderConfigNotFoundException exception for invalid provider.
     */
    public function testInvalidGetProviderConfig()
    {
        $this->expectException(ProviderConfigNotFoundException::class);

        $manager = new Manager($this->config);
        $manager->getProviderConfig('bar');
    }


    public function testGetProviderClassName()
    {
        $manager = new Manager($this->config);
        $actualClassName = $manager->getProviderClassName('reviews_io');
        $expectedClassName = 'PodPoint\\Reviews\\Providers\\ReviewsIo\\Provider';

        $this->assertEquals($expectedClassName, $actualClassName);

    }
}
