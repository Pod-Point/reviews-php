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
    const CLIENT_ID = 'client_id';
    const CLIENT_SECRET = 'client_secret';
    const USERNAME = 'username';
    const PASSWORD = 'password';

    public function requiredFields(): array
    {
        return [
            self::CLIENT_ID,
            self::CLIENT_SECRET,
            self::USERNAME,
            self::PASSWORD,
        ];
    }

    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $key = base64_encode("{$this->getOption(self::CLIENT_ID)}:{$this->getOption(self::CLIENT_SECRET)}");

        $method = 'POST';
        $uri = '/v1/oauth/oauth-business-users-for-applications/accesstoken';
        $header = [
            'Authorization' => "Basic {$key}",
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $body = http_build_query([
            'grant_type' => 'password',
            self::USERNAME => $this->getOption(self::USERNAME),
            self::PASSWORD => $this->getOption(self::PASSWORD),
        ]);

        return new Request($method, $uri, $header, $body);
    }

    /**
     * Sends request and returns AccessToken model.
     *
     * @return array|mixed|AccessToken
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
