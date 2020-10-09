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

    protected $defaultRequestHeaders = [
        'content-type' => 'application/json'
    ];

    protected $baseUri = 'https://api.reviews.co.uk';

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
            $this->addAuthenticationHeader($request);
        }

        $this->addDefaultRequestHeaders($request);

        return $this->httpClient->send($request);
    }

    /**
     * Adding authentication header
     *
     * @param Request $request
     */
    public function addAuthenticationHeader(Request &$request)
    {
        $request = $request->withHeader('apikey', $this->apiKey);
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
