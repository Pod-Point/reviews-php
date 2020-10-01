<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;

class ProductReview implements ReviewsInterface
{
    /**
     * @var array
     */
    protected $apiClient;

    /**
     * ProductReview constructor.
     *
     * @param TrustpilotApiClient $apiClient
     */
    public function __construct(TrustpilotApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
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
