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

    /**
     * @param array $options
     */
    public function invite(array $options)
    {
        //
    }

    /**
     * @param array $options
     */
    public function fetchAll(array $options)
    {
        //
    }

    /**
     * @param string $reference
     */
    public function find(string $reference)
    {
        //
    }
}
