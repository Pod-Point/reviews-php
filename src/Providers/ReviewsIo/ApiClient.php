<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class ApiClient
 * @package PodPoint\Reviews\Providers\ReviewsIo
 */
class ApiClient extends AbstractApiClient
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * ApiClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        parent::__construct();

        $this->apiKey = $apiKey;
    }

    /**
     * Sends request to API with or without pre authentication and returns response.
     *
     * @param Request $request
     * @param bool $withAuthentication
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public function sendRequest(Request $request, bool $withAuthentication = false): ResponseInterface
    {
        if ($withAuthentication) {
            $request = $request->withHeader('apikey', $this->apiKey);
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
}
