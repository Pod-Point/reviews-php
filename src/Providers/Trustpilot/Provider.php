<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;

/**
 * Class Provider.
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
            $config[AccessTokenRequest::CLIENT_ID],
            $config[AccessTokenRequest::CLIENT_SECRET],
            $config[AccessTokenRequest::USERNAME],
            $config[AccessTokenRequest::PASSWORD]
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
