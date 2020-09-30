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
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     *
     * @throws GuzzleException
     */
    protected function getAccessToken(): AccessToken
    {
        $apiKey = config('review-providers.providers.trustpilot.api_key');
        $secretKey = config('review-providers.providers.trustpilot.secret_key');
        $username = config('review-providers.providers.trustpilot.username');
        $password = config('review-providers.providers.trustpilot.password');

        $key = base64_encode($apiKey.':'.$secretKey);

        $response = $this->httpClient->request(
            'POST',
            'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken', [
            'headers' => [
                'authorization' => "Basic {$key}",
            ],
            'form_params' => [
                'grant_type' => 'password',
                'password' => $password,
                'username' => $username,
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
