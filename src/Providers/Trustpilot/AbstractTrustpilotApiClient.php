<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Providers\Trustpilot\Auth\Configuration as AuthenticationConfiguration;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractTrustpilotApiClient extends \PodPoint\Reviews\AbstractApiClient
{
    protected $authConfig;

    public function __construct(ClientInterface $httpClient, AuthenticationConfiguration $authConfig)
    {
        parent::__construct($httpClient);

        $this->authConfig = $authConfig;
    }

    /**
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     *
     * @throws GuzzleException
     */
    protected function getAccessToken(): AccessToken
    {
        $key = base64_encode("{$this->authConfig->apiKey}:{$this->authConfig->secretKey}");

        $response = $this->httpClient->request(
            'POST',
            'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken', [
            'headers' => [
                'authorization' => "Basic {$key}",
            ],
            'form_params' => [
                'grant_type' => 'password',
                'password' => $this->authConfig->password,
                'username' => $this->authConfig->username,
            ],
        ]);

        $json = $this->getResponseJson($response);

        return new AccessToken($json);
    }

    /***
     * @param string $httpMethod
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @param bool $withAuthentication
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    protected function validateAndSendRequest(
        string $httpMethod,
        string $uri,
        array $body,
        array $headers,
        bool $withAuthentication = false
    ): ResponseInterface {

        $this->validate();

        $accessToken = $this->getAccessToken();

        if ($withAuthentication) {
            $headers['authorization'] = "Bearer {$accessToken->accessToken}";
        }

        return $this->httpClient->send(new Request($httpMethod, $uri, $headers, $body));
    }

}
