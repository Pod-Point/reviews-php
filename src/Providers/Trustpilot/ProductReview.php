<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;

class ProductReview implements ReviewsInterface
{
    protected $config;

    /**
     * ProductReview constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function invite(array $options)
    {
        // TODO: Implement invite() method.
    }

    public function fetchAll(array $options)
    {
        // TODO: Implement fetchAll() method.
    }

    public function find(string $reference)
    {
        // TODO: Implement find() method.
    }
}
