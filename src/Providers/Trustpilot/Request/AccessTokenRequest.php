<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Request\BaseRequest;

/**
 * Class AccessTokenRequest
 * @package PodPoint\Reviews\Providers\Trustpilot\Request
 */
class AccessTokenRequest extends BaseRequest
{
    const API_KEY = 'apiKey';
    const API_SECRET = 'apiSecret';
    const USERNAME = 'username';
    const PASSWORD = 'password';

    public function requiredFields(): array
    {
        return [
            self::API_KEY,
            self::API_SECRET,
            self::USERNAME,
            self::PASSWORD,
        ];
    }

    public function getRequest(): Request
    {
        $key = base64_encode($this->getOption(self::API_KEY) . ':' . $this->getOption(self::API_SECRET));

        $method = 'POST';
        $uri = 'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken';
        $header = [
            'authorization' => "Basic {$key}",
        ];

        $body = \GuzzleHttp\json_encode([
            'form_params' => [
                'grant_type' => 'password',
                self::USERNAME => $this->getOption(self::USERNAME),
                self::PASSWORD => $this->getOption(self::PASSWORD),
            ]
        ]);

        return new Request($method, $uri, $header, $body);
    }

    /**
     * Sends request and returns AccessToken model.
     *
     * @return array|mixed|AccessToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        /*
         * The sendRequest withAuthentication parameter must be set to false,
         * this class is used AccessToken provider if not set to false it will
         * go into infinite loop.
         */
        $response = $this->httpClient->sendRequest(
            $this->getRequest(),
            false
        );

        $json = $this->httpClient->getResponseJson($response);

        return new AccessToken($json);
    }
}
