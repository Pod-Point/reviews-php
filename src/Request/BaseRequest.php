<?php

namespace PodPoint\Reviews\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AbstractApiClient;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;

abstract class BaseRequest
{
    /** @var array $option */
    protected $options;

    /** @var Client $httpClient */
    protected $httpClient;

    /**
     * BaseRequest constructor.
     *
     * @param AbstractApiClient $client
     * @param array $options
     *
     * @throws ValidationException
     */
    public function __construct(ApiClientInterface $client, array $options)
    {
        $this->httpClient = $client;
        $this->options = $options;

//        $this->validate();
    }

    /**
     * Get http client.
     *
     * @return Client|AbstractApiClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return array
     */
    abstract protected function requiredFields(): array;

    /**
     * @return Request
     */
    abstract protected function getRequest(): Request;

    /**
     * @return array|mixed
     */
    abstract public function send();

    /**
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(): bool
    {

        $requiredFields = $this->requiredFields();

        foreach ($requiredFields as $field) {
            $value = $this->options[$field];

            if (!isset($value) || empty(null)) {
                throw new ValidationException("$field is required");
            }
        }

        return true;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getOption(string $key)
    {
        return $this->options[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
