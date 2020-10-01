<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

use PodPoint\Reviews\ReviewsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;

class Factory implements ReviewsServiceInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ReviewsCoUkApiClient
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

        $this->apiClient = new ReviewsCoUkApiClient(
            $config['api_key']
        );
    }

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface
    {
        return new ServiceReview($this->apiClient);
    }

    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface
    {
        return new ProductReview($this->apiClient);
    }
}
