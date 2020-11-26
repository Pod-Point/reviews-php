<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\ActionsInterface;

/**
 * Class ProductActions.
 */
class ProductActions implements ActionsInterface
{
    /**
     * Api Client.
     *
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

    /**
     * Invite consumers.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function invite(array $options)
    {
        //
    }

    /**
     * Get reviews.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getReviews(array $options = [])
    {
        //
    }

    /**
     * Find reviews by id.
     *
     * @param string $reviewId
     *
     * @return mixed
     */
    public function findReview(string $reviewId)
    {
        //
    }
}
