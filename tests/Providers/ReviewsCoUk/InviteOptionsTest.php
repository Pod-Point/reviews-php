<?php

namespace PodPoint\Reviews\Tests\Providers\ReviewsCoUK;

use PodPoint\Reviews\Providers\ReviewsCoUk\InviteOptions;
use PodPoint\Reviews\Tests\TestCase;

class InviteOptionsTest extends TestCase
{
    /**
     * Tests that when you create a new InviteOptions object from the InviteOptions class the values are correctly
     * mapped from the array passed to the constructor to the relevant object's variables.
     *
     */
    public function testNewlyCreatedInviteOptionsMapsValuesCorrectly()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $orderNumber = $this->faker->uuid;

        $getOptions = new InviteOptions([
            'name' => $name,
            'email' => $email,
            'orderNumber' => $orderNumber,
        ]);

        $this->assertEquals($getOptions->name, $name);
        $this->assertEquals($getOptions->email, $email);
        $this->assertEquals($getOptions->orderNumber, $orderNumber);
    }
}
