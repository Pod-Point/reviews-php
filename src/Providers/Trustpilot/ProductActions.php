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
     * @var array
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

    public function fetchAll(array $options)
    {
        // TODO: Implement fetchAll() method.
    }

    public function find(string $reference)
    {
        // TODO: Implement find() method.
    }
}
