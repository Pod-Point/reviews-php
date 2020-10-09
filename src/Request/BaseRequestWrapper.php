<?php

namespace PodPoint\Reviews\Request;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;

/**
 * Class BaseRequestWrapper
 * @package PodPoint\Reviews\Request
 */
abstract class BaseRequestWrapper extends BaseRequest
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
        parent::__construct($client, $options);
        $this->validate();
    }
}
