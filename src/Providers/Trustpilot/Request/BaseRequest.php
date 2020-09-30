<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PodPoint\Reviews\Exceptions\ValidationException;

abstract class BaseRequest
{
    protected $options;

    /**
     * BaseRequest constructor.
     *
     * @param array $options
     * @throws ValidationException
     */
    public function __construct(array $options)
    {
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
     * @return Response
     */
    abstract protected function send(): Response;

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
