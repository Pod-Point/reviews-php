<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;

class ReviewsProvider implements ReviewsServiceInterface
{

    protected $config;

    /**
     * ReviewsProvider constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface
    {
        return new ProductReview($this->config);
    }

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface
    {
        return new ServiceReview($this->config);
    }
}
