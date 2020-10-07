<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;

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
