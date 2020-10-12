<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;

/**
 * Class ProductActions.
 */
class ProductActions implements ActionsInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * Provider config.
     *
     * @var array
     */
    protected $config;

    /**
     * ProductReview constructor.
     *
     * @param ApiClientInterface $apiClient
     * @param array $config
     */
    public function __construct(ApiClientInterface $apiClient, array $config)
    {
        $this->apiClient = $apiClient;
        $this->config = $config;
    }

    public function invite(array $options)
    {
        //
    }

    public function getReviews(array $options = [])
    {
        //
    }

    public function findReview(string $reviewId)
    {
        //
    }
}
