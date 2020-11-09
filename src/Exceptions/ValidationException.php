<?php

namespace PodPoint\Reviews\Exceptions;

use Throwable;

/**
 * Class ValidationException.
 */
class ValidationException extends \Exception
{
    /**
     * ValidationException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
