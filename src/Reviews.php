<?php

namespace PodPoint\Reviews;

use PodPoint\Reviews\Exceptions\ProviderConfigNotFoundException;
use PodPoint\Reviews\Exceptions\ProviderNotFoundException;

/**
 * Reviews Class. Acts as the entrypoint to the package.
 */
class Reviews
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
     *
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
        $class = $this->getProviderClassName($provider);

        if (!class_exists($class)) {
            throw new ProviderNotFoundException($class);
        }

        $providerConfig = $this->getProviderConfig($provider);

        return new $class($providerConfig);
    }

    /**
     * Builds the provider class name, removes _ and changes first character
     * after _ to upper case.
     *
     * @param string $provider
     *
     * @return string
     */
    public function getProviderClassName(string $provider): string
    {
        $provider = ucfirst($provider);
        $providerNamePartials = explode('_', $provider);

        foreach ($providerNamePartials as $partialKey => $partial) {
            $providerNamePartials[$partialKey] = ucfirst($partial);
        }

        $providerName = implode('', $providerNamePartials);

        return "PodPoint\\Reviews\\Providers\\{$providerName}\\Provider";
    }

    /**
     * Magic method used to create provider, when the method doesn't exist it will return new instance of the provider,
     * compatible with Laravel Facade.
     *
     * Example usage:
     * Reviews::trustpilot() which is equivalent to (new Reviews($config))->withProvider('trustpilot');
     *
     * @param $name
     * @param $arguments
     * @return ProviderInterface
     * @throws ProviderConfigNotFoundException
     * @throws ProviderNotFoundException
     */
    public function __call($name, $arguments)
    {
        return $this->withProvider($name);
    }
}
