<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest;
use Psr\Http\Message\ResponseInterface;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class TrustpilotApiClient
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class TrustpilotApiClient extends AbstractApiClient
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * TrustpilotApiClient constructor.
     *
     * @param string $apiKey
     * @param string $secretKey
     * @param string $username
     * @param string $password
     */
    public function __construct(string $apiKey, string $secretKey, string $username, string $password)
    {
        parent::__construct();

        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
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
            AccessTokenRequest::API_KEY => $this->apiKey,
            AccessTokenRequest::API_SECRET => $this->secretKey,
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

            $request->withHeader('authorization', "Bearer {$accessToken->accessToken}");
        }

        return $this->httpClient->send($request);
    }

    /**
     * Returns client API key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Returns client API secret key.
     *
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
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
