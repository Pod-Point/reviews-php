<?php

namespace PodPoint\Reviews\Request;

/**
 * Class BaseRequest
 * @package PodPoint\Reviews\Request
 */
abstract class BaseRequestWrapper extends BaseRequest
{
    public function __construct($client, $options)
    {
        parent::__construct($client, $options);
        $this->validate();
    }
}
