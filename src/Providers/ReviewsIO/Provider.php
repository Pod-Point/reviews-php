<?php

namespace PodPoint\Reviews\Providers\ReviewsIO;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;

class Provider implements ProviderInterface
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
     * @return ActionsInterface
     */
    public function service(): ActionsInterface
    {
        return new ServiceActions($this->apiClient);
    }

    /**
     * @return ActionsInterface
     */
    public function product(): ActionsInterface
    {
        return new ProductActions($this->apiClient);
    }
}
