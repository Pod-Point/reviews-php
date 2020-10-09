<?php

namespace PodPoint\Reviews;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApiClient
 * @package PodPoint\Reviews
 */
abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * Instance of GuzzleHttp/Client.
     *
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * Default headers, attached to every request.
     *
     * @var string[]
     */
    protected $defaultRequestHeaders = [];

    /**
     * AbstractApiClient constructor, creates an instance of http client.
     *
     * @param ClientInterface|null $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Sends request to API with or without pre authentication and returns response.
     *
     * @param Request $request
     * @param bool $withAuthentication
     *
     * @return ResponseInterface
     */
    abstract public function sendRequest(Request $request, bool $withAuthentication);

    /**
     * @return Client|ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Sets httpClient.
     *
     * @param ClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Retrieves the JSON from a HTTP response.
     *
     * @param ResponseInterface $response
     * @return array
     */
    public function getResponseJson(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();

        return \GuzzleHttp\json_decode($body, true);
    }

    /**
     * Adds required default headers.
     *
     * @param Request $request
     */
    public function addDefaultRequestHeaders(Request &$request)
    {
        /**
         * Adding default headers, if not overridden.
         */
        foreach ($this->defaultRequestHeaders as $headerKey => $headerValue)
        {
            if(!$request->hasHeader($headerKey)) {
                $request = $request->withHeader($headerKey, $headerValue);
            }
        }
    }

    public abstract function addAuthenticationHeader(Request &$request);
}
