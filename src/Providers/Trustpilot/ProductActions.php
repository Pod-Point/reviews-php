<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\ActionsInterface;

/**
 * Class ProductActions
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class ProductActions implements ActionsInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * ProductReview constructor.
     *
     * @param ApiClientInterface $apiClient
     */
    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Invite consumers.
     *
     * @param array $options
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
