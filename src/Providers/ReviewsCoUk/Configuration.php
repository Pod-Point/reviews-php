<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

class Configuration
{
    /**
     * The reviews.co.uk api url.
     *
     * @var string
     */
    public string $url;

    /**
     * The reviews.co.uk store.
     *
     * @var string
     */
    public string $store;

    /**
     * The reviews.co.uk api key.
     *
     * @var string
     */
    public string $apiKey;

    /**
     * Sets all the configuration from the given array.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->url = $config['url'];
        $this->store = $config['store'];
        $this->apiKey = $config['apiKey'];
    }
}
