<?php

namespace PodPoint\Reviews\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $faker;

    /**
     * Creates a new instance of faker
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
    }
}
