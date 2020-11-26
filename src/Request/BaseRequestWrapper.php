<?php

namespace PodPoint\Reviews\Request;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;

/**
 * Class BaseRequestWrapper.
 */
abstract class BaseRequestWrapper extends AbstractBaseRequest
{
    /**
     * BaseRequestWrapper class constructor.
     *
     * @param ApiClientInterface $client
     * @param array $options
     *
     * @throws ValidationException
     */
    public function __construct(ApiClientInterface $client, array $options)
    {
        parent::__construct($options, $client);
        $this->validate();
    }
}
