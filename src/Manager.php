<?php

namespace PodPoint\Reviews;

use PodPoint\Reviews\Exceptions\ProviderConfigNotFoundException;
use PodPoint\Reviews\Exceptions\ProviderNotFoundException;

/**
 * Class Manager
 *
 * @package PodPoint\Reviews
 */
class Manager
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Expects configurations.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Returns all the configs.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Returns provider specific config.
     *
     * @param string $provider
     * @return mixed
     * @throws ProviderConfigNotFoundException
     */
    public function getProviderConfig(string $provider)
    {
        if (!isset($this->config[$provider])) {
            throw new ProviderConfigNotFoundException();
        }

        return $this->config[$provider];
    }

    /**
     * Returns the provider of specific vendor.
     *
     * @param string $provider
     *
     * @return ProviderInterface
     * @throws ProviderConfigNotFoundException
     * @throws ProviderNotFoundException
     */
    public function withProvider(string $provider): ProviderInterface
    {
        $class = 'PodPoint\\Reviews\\Providers\\' . ucfirst($provider) . '\\Provider';

        if (!class_exists($class)) {
            throw new ProviderNotFoundException($class);
        }

        $providerConfig = $this->getProviderConfig($provider);

        return new $class($providerConfig);
    }

    /**
     * @return ProviderInterface
     * @throws ProviderConfigNotFoundException
     * @throws ProviderNotFoundException
     */
    public function trustpilot()
    {
        return $this->withProvider('trustpilot');
    }
}
