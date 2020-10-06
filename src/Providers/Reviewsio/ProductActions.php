<?php

namespace PodPoint\Reviews\Providers\Reviewsio;

use PodPoint\Reviews\ActionsInterface;

class ProductActions implements ActionsInterface
{
    /**
     * @var array
     */
    protected $apiClient;

    /**
     * ProductReview constructor.
     *
     * @param ReviewsCoUkApiClient $apiClient
     */
    public function __construct(ReviewsCoUkApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function invite(array $options)
    {
        // TODO: Implement invite() method.
    }

    public function getReviews(array $options)
    {
        // TODO: Implement fetchAll() method.
    }

    public function findReview(string $reviewId)
    {
        // TODO: Implement find() method.
    }
}
