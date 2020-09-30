<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\AbstractApiClient;
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
    public function __construct(AbstractApiClient $client, array $options)
    {
        $this->httpClient = $client;
        $this->options = $options;
        $this->validate();
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
    abstract protected function send();

    /**
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(): bool
    {
        $requiredFields = $this->requiredFields();

        foreach ($requiredFields as $field) {
            if (!isset($this->options[$field])) {
                throw new ValidationException("$field is required");
            }
        }

        return true;
    }

    public function getOption(string $key)
    {
        return $this->options[$key] ?? null;
    }
}
