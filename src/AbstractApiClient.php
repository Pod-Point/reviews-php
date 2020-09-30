<?php


namespace PodPoint\Reviews;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiClient
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /***
     * @return Client|ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Retrieves the JSON from a HTTP response.
     *
     * @param ResponseInterface $response
     * @return array
     */
    protected function getResponseJson(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();

        return \GuzzleHttp\json_decode($body, true);
    }


}
