<?php


namespace PodPoint\Reviews;


use GuzzleHttp\ClientInterface;

abstract class AbstractApiClient
{

    /**
     * @var ClientInterface
     */
    protected ClientInterface $httpClient;

    public function __construct(ClientInterface  $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return mixed
     */
    public abstract function getEndpoint();

    /**
     * @return mixed
     */
    public abstract function send();
}
