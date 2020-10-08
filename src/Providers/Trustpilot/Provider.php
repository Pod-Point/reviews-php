<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ProviderInterface;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;

/**
 * Class Provider
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class Provider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var TrustpilotApiClient
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


        $this->apiClient = new TrustpilotApiClient(
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
    public function service(): ActionsInterface
    {
        return (new MerchantActions($this->apiClient))->setMerchantId($this->config['business_unit_id']);
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
    public function getConfig(): array
    {
        return $this->config;
    }
}
