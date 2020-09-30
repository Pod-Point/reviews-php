<?php

namespace PodPoint\Reviews;

use PodPoint\Reviews\Exceptions\ProviderNotFoundException;

/**
 * Class Manager
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
     * @param $provider
     * @return mixed
     * @throws ProviderNotFoundException
     */
    public function withProvider($provider): ReviewsServiceInterface
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
        $class = 'PodPoint\\Reviews\\Providers\\' . ucfirst($provider) .'\\ReviewsProvider';

        if (!class_exists($class)) {
            throw new ProviderNotFoundException($class);
        }

        return new $class($this->config['providers'][$provider]);
    }
}
