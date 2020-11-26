<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\Exceptions\InvalidTimeUnitException;
use PodPoint\Reviews\TimeUnitConverter;

class TimeUnitConverterTest extends TestCase
{
    protected $converter;

    /**
     * Setting up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->converter = new TimeUnitConverter();
    }

    /**
     * Making sure seconds are converted into minutes.
     */
    public function testConvertSecondsToMinutes()
    {
        $valueInSeconds = 3600;

        $convertedValue = $this->converter->convertSecondsToMinutes($valueInSeconds);

        $this->assertIsInt($convertedValue);
        $this->assertEquals(60, $convertedValue);
    }

    /**
     * Making sure minutes are converted into seconds.
     */
    public function testConvertMinutesToSeconds()
    {
        $valueInSeconds = 60;

        $convertedValue = $this->converter->convertMinutesToSeconds($valueInSeconds);

        $this->assertIsInt($convertedValue);
        $this->assertEquals(3600, $convertedValue);
    }

    /**
     * Making sure exception is thrown when the unit from and to is set to invalid
     * time units.
     */
    public function testValidateShouldThrowExceptionForInvalidUnitFromAndTo()
    {
        $this->expectException(InvalidTimeUnitException::class);
        $this->expectExceptionMessage("The specified unit foo is not supported.");

        $this->converter->convert(
            80,
            'foo',
            'bar'
        );

        $this->expectExceptionMessage("The specified unit bar is not supported.");
        $this->converter->convert(
            80,
            'seconds',
            'bar'
        );
    }

    public function convertDataProvider()
    {
        return [
            'Should pass: Convert from seconds to minutes' => [
                $state = [
                    'from' => 'seconds',
                    'to' => 'minutes',
                    'value' => 3600
                ],
                $expected = 60

            ],
            'Should pass: Convert from minutes to seconds' => [
                $state = [
                    'from' => 'minutes',
                    'to' => 'seconds',
                    'value' => 12
                ],
                $expected = 720
            ]
        ];
    }

    /**
     * Making sure the convert method can convert between supported time units.
     *
     * @dataProvider convertDataProvider
     */
    public function testConvert($state, $expected)
    {
        $actual = $this->converter
            ->convert(
                $state['value'],
                $state['from'],
                $state['to']
            );

        $this->assertEquals($expected, $actual);
    }
}
