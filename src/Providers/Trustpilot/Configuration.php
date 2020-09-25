<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

class Configuration
{
    /**
     * The Trustpilot application API key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * The Trustpilot business unit ID.
     *
     * @var string
     */
    public $businessUnitId;

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
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->apiKey = $config['apiKey'];
        $this->businessUnitId = $config['businessUnitId'];
        $this->password = $config['password'];
        $this->secretKey = $config['secretKey'];
        $this->username = $config['username'];
    }
}
