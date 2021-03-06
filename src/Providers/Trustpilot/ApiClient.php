<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class ApiClient.
 */
class ApiClient extends AbstractApiClient
{
    /**
     * @var array
     */
    protected $defaultRequestHeaders = [
        'content-type' => 'application/json'
    ];

    /**
     * @var string
     */
    protected $baseUri = 'https://api.trustpilot.com';

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * ApiClient constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $username
     * @param string $password
     */
    public function __construct(string $clientId, string $clientSecret, string $username, string $password)
    {
        parent::__construct();

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     *
     * @throws GuzzleException|\PodPoint\Reviews\Exceptions\ValidationException
     */
    public function getAccessToken(): AccessToken
    {
        $options = [
            AccessTokenRequest::CLIENT_ID => $this->clientId,
            AccessTokenRequest::CLIENT_SECRET => $this->clientSecret,
            AccessTokenRequest::USERNAME => $this->username,
            AccessTokenRequest::PASSWORD => $this->password,
        ];

        $request = new AccessTokenRequest($this, $options);

        return $request->send();
    }

    /**
     * Returns client API key.
     *
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Returns client API secret key.
     *
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Returns client API username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Returns client API password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Pre authenticates the app and attaches access token to all.
     *
     * @param Request $request
     *
     * @throws GuzzleException
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function addAuthenticationHeader(Request &$request)
    {
        $accessToken = $this->getAccessToken();

        $request = $request->withHeader('Authorization', "Bearer {$accessToken->accessToken}");
    }
}
