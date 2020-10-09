<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;

/**
 * Class Provider
 * @package PodPoint\Reviews\Providers\ReviewsIo
 */
class Provider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ApiClient
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

        $this->apiClient = new ApiClient(
            $config['api_key']
        );
    }

    /**
     * Returns service actions by setting config.
     *
     * @return ActionsInterface
     */
    public function merchant(): ActionsInterface
    {
        return new MerchantActions($this->apiClient, $this->config);
    }

    /**
     * Returns production actions by setting config.
     *
     * @return ActionsInterface
     */
    public function product(): ActionsInterface
    {
        return new ProductActions($this->apiClient, $this->config);
    }

    /**
     * Returns provider config.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
