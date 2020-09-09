<?php


namespace PodPoint\Reviews\Tests\Providers\ReviewsCoUK;

use PodPoint\Reviews\Providers\ReviewsCoUk\Configuration;
use PodPoint\Reviews\Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Tests that when you create a new Configuration object from the Configuration class the values are correctly
     * mapped from the array passed to the constructor to the relevant object's variables.
     */
    public function testNewlyCreatedConfigurationMapsValuesCorrectly()
    {
        $url = $this->faker->url;
        $store = $this->faker->text;
        $apiKey = $this->faker->uuid;

        $configuration = new Configuration([
            'url' => $url,
            'store' => $store,
            'apiKey' => $apiKey,
        ]);

        $this->assertEquals($configuration->url, $url);
        $this->assertEquals($configuration->store, $store);
        $this->assertEquals($configuration->apiKey, $apiKey);
    }
}
