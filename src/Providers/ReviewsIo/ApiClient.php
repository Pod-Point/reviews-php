<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use GuzzleHttp\Psr7\Request;
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
