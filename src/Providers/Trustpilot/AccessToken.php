<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

class AccessToken
{
    /**
     * The OAuth2 access token.
     *
     * @var string
     */
    public string $accessToken;

    /**
     * The tokens TTL in seconds.
     *
     * @var int
     */
    public int $expiresIn;

    /**
     * The OAuth2 refresh token.
     *
     * @var string
     */
    public string $refreshToken;

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
