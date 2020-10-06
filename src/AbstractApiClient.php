<?php

namespace PodPoint\Reviews;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * Instance of GuzzleHttp/Client.
     *
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * AbstractApiClient constructor, creates an instance of http client.
     */
    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * @param Request $request
     * @param bool $withAuthentication
     * @return mixed
     */
    abstract public function sendRequest(Request $request, bool $withAuthentication);

    /***
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
}
