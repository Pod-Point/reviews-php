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
        $class = get_class('PodPoint\\Reviews\\Providers\\' . ucfirst($provider) .'\\Service');

        if (!$class) {
            throw new ProviderNotFoundException($class);
        }

        $configs = include __DIR__ . "/config/review-providers.php";

        return new $class();
    }
}
