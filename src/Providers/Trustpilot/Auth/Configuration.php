<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Auth;

use Illuminate\Support\Facades\Config;

class Configuration
{
    /**
     * The Trustpilot application API key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * The Trustpilot account password.
     *
     * @var string
     */
    public $password;

    /**
     * The Trustpilot application secret key.
     *
     * @var string
     */
    public $secretKey;

    /**
     * The Trustpilot account username.
     *
     * @var string
     */
    public $username;

    /**
     * Sets all the configuration from the given array.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->apiKey = $config->get('review-providers.providers.trustpilot.api_key');
        $this->secretKey = $config->get('review-providers.providers.trustpilot.secret_key');
        $this->username = $config->get('review-providers.providers.trustpilot.username');
        $this->password = $config->get('review-providers.providers.trustpilot.password');
    }
}
