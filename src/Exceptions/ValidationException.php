<?php

namespace PodPoint\Reviews\Exceptions;

use Throwable;

/**
 * Class ValidationException.
 */
class ValidationException extends \Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
