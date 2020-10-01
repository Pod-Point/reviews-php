<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use Psr\Http\Message\ResponseInterface;
use PodPoint\Reviews\AbstractApiClient;

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
     * @throws GuzzleException
     */
    protected function getAccessToken(): AccessToken
    {
        $key = base64_encode($this->apiKey . ':' . $this->secretKey);

        $response = $this->httpClient->request(
            'POST',
            'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken', [
            'headers' => [
                'authorization' => "Basic {$key}",
            ],
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
            ],
        ]);

        $json = $this->getResponseJson($response);

        return new AccessToken($json);
    }

    /***
     * @param Request $request
     * @param bool $withAuthentication
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public function validateAndSend(Request $request, bool $withAuthentication = false): ResponseInterface
    {
        if ($withAuthentication) {
            $accessToken = $this->getAccessToken();

            $request->withHeader('authorization', "Bearer {$accessToken->accessToken}");
        }

        return $this->httpClient->send($request);
    }
}
