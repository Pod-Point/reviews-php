<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;

class ReviewsProvider implements ReviewsServiceInterface
{

    protected $config;

    protected $apiClient;

    /**
     * ReviewsProvider constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->apiClient = new TrustpilotApiClient();
    }

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface
    {
        return (new ServiceReview($this->apiClient))
            ->setBusinessUnitId($this->config['businessId']);
    }

    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface
    {
        return new ProductReview($this->config);
    }

}
