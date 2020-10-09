<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;
use Psr\Http\Message\ResponseInterface;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class ApiClient
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class ApiClient extends AbstractApiClient
{
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
     * Sends request to API with or without pre authentication and returns response.
     *
     * @param Request $request
     * @param bool $withAuthentication
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException|\PodPoint\Reviews\Exceptions\ValidationException
     */
    public function sendRequest(Request $request, bool $withAuthentication = false): ResponseInterface
    {
        if ($withAuthentication) {
            $accessToken = $this->getAccessToken();

            $request = $request->withHeader('Authorization', "Bearer {$accessToken->accessToken}");
        }

        return $this->httpClient->send($request);
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
}
