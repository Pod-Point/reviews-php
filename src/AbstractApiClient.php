<?php

namespace PodPoint\Reviews;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApiClient. Holds functions used by the APIClients in each provider.
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
     * The base uri that will be used to make request.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * AbstractApiClient constructor, creates an instance of http client.

     * @param ClientInterface|null $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client(['base_uri' => $this->baseUri]);
    }

    /**
     * Sends request to API with or without pre authentication and returns response.
     *
     * @param Request $request
     * @param boolean $withAuthentication
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException|\PodPoint\Reviews\Exceptions\ValidationException
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
     * Returns the httpClient from the instantiated ApiClient.
     *
     * @return Client|ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Sets httpClient.
     *
     * @param  ClientInterface $httpClient
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
     * When the response content body is empty, json encode will fail and return empty array instead.
     *
     * @param  ResponseInterface $response
     * @return array
     */
    public function getResponseJson(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        $body = empty($body) ? '{}' : $body;

        return \GuzzleHttp\json_decode($body, true);
    }

    /**
     * Adds required default headers.
     *
     * @param Request $request
     */
    public function addDefaultRequestHeaders(Request &$request)
    {
        foreach ($this->defaultRequestHeaders as $headerKey => $headerValue) {
            if (!$request->hasHeader($headerKey)) {
                $request = $request->withHeader($headerKey, $headerValue);
            }
        }
    }

    abstract public function addAuthenticationHeader(Request &$request);
}
