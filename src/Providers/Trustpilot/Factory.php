<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;

class Factory implements ReviewsServiceInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var TrustpilotApiClient
     */
    protected $apiClient;

    /**
     * ReviewsProvider constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->apiClient = new TrustpilotApiClient(
            $config['api_key'],
            $config['api_secret'],
            $config['username'],
            $config['password']
        );
    }

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface
    {
        return (new ServiceReview($this->apiClient))->setBusinessUnitId($this->config['businessUnitId']);
    }

    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface
    {
        return new ProductReview($this->config);
    }

}
