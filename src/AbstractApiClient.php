<?php


namespace PodPoint\Reviews;


use GuzzleHttp\ClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiClient
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return mixed
     */
    abstract public function send();

    /**
     * @return array
     */

    /**
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate(): bool
    {
        $requiredFields = $this->requiredFields();

        foreach ($requiredFields as $field) {
            if (!isset($this->{$field})) {
                throw new ValidationException("$field is required");
            }
        }

        return true;
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
