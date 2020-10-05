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
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function getProviderConfig(string $provider)
    {
        if (!isset($this->config['providers']) || !isset($this->config['providers'][$provider])) {
            throw new ProviderConfigNotFoundException();
        }

        return $this->config['providers'][$provider];
    }

    /**
     * @param $provider
     * @return mixed
     * @throws ProviderNotFoundException
     */
    public function withProvider(string $provider): ProviderInterface
    {
        return $this->getProviderInstance($provider);
    }

    /**
     * @param string $provider
     * @return mixed
     * @throws ProviderNotFoundException
     */
    protected function getProviderInstance(string $provider)
    {
        $class = 'PodPoint\\Reviews\\Providers\\' . ucfirst($provider) . '\\Provider';

        if (!class_exists($class)) {
            throw new ProviderNotFoundException($class);
        }

        return new $class($this->config['providers'][$provider]);
    }
}
