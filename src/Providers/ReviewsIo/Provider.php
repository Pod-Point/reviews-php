<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

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
     * Returns service actions by setting config.
     *
     * @return ActionsInterface
     */
    public function service(): ActionsInterface
    {
        return (new ServiceActions($this->apiClient))->setStore($this->config['store']);
    }

    /**
     * Returns production actions by setting config.
     *
     * @return ActionsInterface
     */
    public function product(): ActionsInterface
    {
        return new ProductActions($this->apiClient);
    }

    /**
     * Returns provider config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
