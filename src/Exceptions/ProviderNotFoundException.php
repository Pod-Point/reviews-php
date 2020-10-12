<?php

namespace PodPoint\Reviews\Exceptions;

use Throwable;

/**
 * Class ProviderNotFoundException.
 */
class ProviderNotFoundException extends \Exception
{
    protected $message = 'Provider was not found!';

    /**
     * Throws message for given class name.
     *
     * ProviderNotFoundException constructor.
     * @param string $class
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($class = '', $code = 0, Throwable $previous = null)
    {
        if (empty($class)) {
            $message = $this->message;
        } else {
            $message = "Provider service for '$class' was not found!";
        }

        parent::__construct($message, $code, $previous);
    }
}
