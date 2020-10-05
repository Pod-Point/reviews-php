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

    public function requiredFields(): array
    {
        return [
            'apiKey',
            'apiSecret',
            'username',
            'password'
        ];
    }

    protected function getRequest(): Request
    {
        $key = base64_encode($this->options['apiKey'] . ':' . $this->options['secretKey']);

        $method = 'POST';
        $uri = 'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken';
        $header = [
            'authorization' => "Basic {$key}",
        ];

        $body = [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->getOption('username'),
                'password' => $this->getOption('password'),
            ]
        ];

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
        $response = $this->httpClient->send($this->getRequest());

        $json = $this->httpClient->getResponseJson($response);

        return new AccessToken($json);
    }
}
