<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AccessToken;
use PodPoint\Reviews\Request\AbstractCacheableRequest;

/**
 * Class AccessTokenRequest.
 */
class AccessTokenRequest extends AbstractCacheableRequest
{
    /**
     * @var string
     */
    const CLIENT_ID = 'client_id';

    /**
     * @var ApiClient
     */
    const CLIENT_SECRET = 'client_secret';

    /**
     * @var ApiClient
     */
    const URI = '/v1/oauth/oauth-business-users-for-applications/accesstoken';

    /**
     * @var ApiClient
     */
    const USERNAME = 'username';

    /**
     * @var ApiClient
     */
    const PASSWORD = 'password';

    /**
     * The sendRequest withAuthentication parameter must be set to false,
     * this class is used AccessToken provider if not set to false it will
     * go into infinite loop.
     *
     * @var bool
     */
    protected $withAuthentication = false;

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
        $header = [
                   'Authorization' => "Basic {$key}",
                   'Content-Type'  => 'application/x-www-form-urlencoded',
                  ];

        $body = http_build_query([
                                  'grant_type'   => 'password',
                                  self::USERNAME => $this->getOption(self::USERNAME),
                                  self::PASSWORD => $this->getOption(self::PASSWORD),
                                 ]);

        return new Request($method, self::URI, $header, $body);
    }

    /**
     * Sends request and returns AccessToken model.
     *
     * @return array|mixed|AccessToken
     *
     * @throws \PodPoint\Reviews\Exceptions\UnauthorizedException
     */
    public function send()
    {
        $json = parent::send();

        return new AccessToken($json);
    }
}
