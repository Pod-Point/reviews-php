<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AbstractApiClient;

/**
 * Class ApiClient.
 */
class ApiClient extends AbstractApiClient
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $defaultRequestHeaders = [
        'content-type' => 'application/json'
    ];

    /**
     * @var string
     */
    protected $baseUri = 'https://api.reviews.io';

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
     * Adding authentication header.
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
