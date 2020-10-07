<?php

namespace PodPoint\Reviews;

/**
 * Class AccessToken
 * @package PodPoint\Reviews
 */
class AccessToken
{
    /**
     * The OAuth2 access token.
     *
     * @var string
     */
    public $accessToken;

    /**
     * The tokens TTL in seconds.
     *
     * @var int
     */
    public $expiresIn;

    /**
     * The OAuth2 refresh token.
     *
     * @var string
     */
    public $refreshToken;

    /**
     * Sets the access token properties from the given array.
     *
     * @param array $token
     */
    public function __construct(array $token)
    {
        $this->accessToken = $token['access_token'];
        $this->expiresIn = $token['expires_in'];
        $this->refreshToken = $token['refresh_token'];
    }
}
