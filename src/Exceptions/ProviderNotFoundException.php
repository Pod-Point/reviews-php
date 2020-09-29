<?php


namespace PodPoint\Reviews\Exceptions;


use Throwable;

class ProviderNotFoundException extends \Exception
{
    protected $message = 'Provider was not found!';

    public function __construct($class = "", $code = 0, Throwable $previous = null)
    {
        if (empty($class)) {
            $message = $this->message;
        } else {
            $message = "Provider service for '$class' was not found!";
        }

        parent::__construct($message, $code, $previous);
    }
}
