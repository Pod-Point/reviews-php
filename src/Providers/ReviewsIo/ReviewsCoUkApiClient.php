<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use PodPoint\Reviews\AbstractApiClient;

class ReviewsCoUkApiClient extends AbstractApiClient
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * ReviewsCoUkApiClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        parent::__construct();

        $this->apiKey = $apiKey;
    }

    /***
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
            $request->withHeader('apikey', $this->apiKey);
        }

        return $this->httpClient->send($request);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
