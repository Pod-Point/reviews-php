<?php


namespace PodPoint\Reviews\Tests\Providers\ReviewsCoUK;

use PodPoint\Reviews\Providers\ReviewsCoUk\GetOptions;
use PodPoint\Reviews\Tests\TestCase;

class GetOptionsTest extends TestCase
{
    /**
     * Tests that when you create a new GetOptions object from the GetOptions class the values are correctly
     * mapped from the array passed to the constructor to the relevant object's variables.
     *
     * In this case when order number is passed the minDate and maxDate variables should NOT be passed.
     */
    public function testPassingOrderNumberToGetOptionDoesNotAddMinDateAndMaxDateToObjectVariables()
    {
        $orderNumber = $this->faker->numberBetween();
        $minDate = $this->faker->date();
        $maxDate = $this->faker->date();

        $getOptions = new GetOptions([
            'orderNumber' => $orderNumber,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ]);

        $this->assertEquals($getOptions->orderNumber, $orderNumber);
        $this->assertEquals($getOptions->minDate, null);
        $this->assertEquals($getOptions->maxDate, null);
    }

    /**
     * Tests that when you create a new GetOptions object from the GetOptions class the values are correctly
     * mapped from the array passed to the constructor to the relevant object's variables.
     *
     * In this case when order number is NOT passed the minDate and maxDate variables should be passed and order number
     * should be null.
     */
    public function testNotPassingOrderNumberToGetOptionDoesAddMinDateAndMaxDateToObjectVariables()
    {
        $minDate = $this->faker->date();
        $maxDate = $this->faker->date();

        $getOptions = new GetOptions([
            'orderNumber' => $this->faker->numberBetween(),
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ]);

        $this->assertEquals($getOptions->orderNumber, null);
        $this->assertEquals($getOptions->minDate, $minDate);
        $this->assertEquals($getOptions->maxDate, $maxDate);
    }
}
