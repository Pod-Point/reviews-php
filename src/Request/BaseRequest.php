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
     * @param ApiClientInterface $client
     * @param array $options
     *
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
    abstract public function requiredFields(): array;

    /**
     * @return Request
     */
    abstract protected function getRequest(): Request;

    /**
     * @return array|mixed
     */
    abstract public function send();

    /**
     * Checks if the required fields are present.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(): bool
    {
        $requiredFields = $this->requiredFields();

        foreach ($requiredFields as $field) {
            if (!isset($this->options[$field]) && empty($this->options[$field])) {
                throw new ValidationException("$field is required");
            }
        }

        return true;
    }

    /**
     * Get option by key name.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getOption(string $key)
    {
        return $this->options[$key] ?? null;
    }

    /**
     * Returns all the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
