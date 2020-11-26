<?php


namespace PodPoint\Reviews;


use PodPoint\Reviews\Exceptions\InvalidTimeUnitException;

/**
 * Class TimeUnitConverter
 *
 * Converts between time units, seconds to minutes and minutes to seconds.
 */
class TimeUnitConverter
{
    /**
     * Supported time units.
     */
    const TIME_UNITS = [
        'seconds' => 'seconds',
        'minutes' => 'minutes',
    ];

    /**
     * Converts between time units.
     *
     * @param int $value
     * @param string $from
     * @param string $to
     *
     * @return int
     * @throws InvalidTimeUnitException
     */
    public function convert(int $value, string $from, string $to): int
    {
        $this->validate($from, $to);

        if ($from === $to) {
            return $value;
        }

        $convertorMethod = "convert{$from}To{$to}";

        return $this->$convertorMethod($value);
    }

    /**
     * Checks if the given units are valid.
     *
     * @param string $from
     * @param string $to
     * @return bool
     * @throws InvalidTimeUnitException
     */
    protected function validate(string $from, string $to)
    {
        $units = [$from, $to];

        foreach ($units as $unit) {
            if (!in_array($unit, self::TIME_UNITS)) {
                throw new InvalidTimeUnitException("The specified unit $unit is not supported.");
            }
        }

        return true;
    }

    /**
     * Converts seconds into minutes.
     *
     * @param int $value
     * @return int
     */
    public function convertSecondsToMinutes(int $value): int
    {
        return (int) $value / 60;
    }

    /**
     * Converts minutes into seconds.
     *
     * @param int $value
     * @return int
     */
    public function convertMinutesToSeconds(int $value): int
    {
        return (int) $value * 60;
    }
}
