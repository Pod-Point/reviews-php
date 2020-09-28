<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use Illuminate\Support\Facades\Config;

class AuthenticationConfiguration
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
        $authConfig = 'review-providers.providers.trustpilot.auth';

        $this->apiKey = $config->get("$authConfig.apiKey");
        $this->secretKey = $config->get("$authConfig.secretKey");
        $this->username = $config->get("$authConfig.username");
        $this->password = $config->get("$authConfig.password");
    }
}
