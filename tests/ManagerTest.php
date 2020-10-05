<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\Exceptions\ProviderNotFoundException;
use PodPoint\Reviews\Manager;

class ManagerTest extends TestCase
{

    protected $config;

    /**
     * Setting up test configs.
     */
    protected function setUp(): void
    {
        $this->mockReviewProviderProvider('Foo');

        $this->config = [
            'providers' => [
                'foo' => [
                    'some_key' => 'API_KEY',
                    'other_key' => 'SECRET_KEY',
                ],
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
}

