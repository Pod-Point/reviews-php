<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

class GetOptions
{
    /**
     * The order number of the review you would like to retrieve.
     *
     * @var string
     */
    public string $orderNumber;

    /**
     * The minimum date of reviews you would like to retrieve.
     *
     * @var string
     */
    public string $minDate;

    /**
     * The maximum date of reviews you would like to retrieve.
     *
     * @var string
     */
    public string $maxDate;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (array_key_exists('orderNumber', $options)) {
            $this->orderNumber = $options['orderNumber'];
        } else {
            $this->minDate = $options['minDate'];
            $this->maxDate = $options['maxDate'];
        }
    }

    /**
     * Checks whether order number has been provided.
     *
     * @return bool
     */
    public function hasOrderNumber()
    {
        return !is_null($this->orderNumber);
    }
}
