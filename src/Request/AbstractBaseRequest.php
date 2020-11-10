<?php

namespace PodPoint\Reviews\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\AbstractApiClient;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;

/**
 * Class BaseRequest. Holds functionality shared by all Request classes across the package.
 */
abstract class AbstractBaseRequest
{
    /**
     * Default headers to attach all requests.
     *
     * @var string[]
     */
    protected $header = [
        'Content-type' => 'application/json',
    ];

    /** @var array $option */
    protected $options;

    /** @var ApiClientInterface $apiClient */
    protected $apiClient;

    protected $withAuthentication  = true;

    /**
     * BaseRequest constructor.
     *
     * @param array $options
     *
     * @param ApiClientInterface $apiClient
     */
    public function __construct(array $options, ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
        $this->options = $options;
    }

    /**
     * Get http client.
     *
     * @return Client|AbstractApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Builds the request.
     *
     * @return Request
     */
    abstract public function getRequest(): Request;

    /**
     * List of required fields.
     *
     * @return array
     */
    abstract public function requiredFields(): array;

    /**
     * Sends the request and parses response into array.
     *
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
    public function getOptions(): array
    {
        return $this->options;
    }
}
