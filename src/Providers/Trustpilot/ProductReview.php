<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;

class ProductReview implements ReviewsInterface
{
    public function invite(array $options)
    {
        //construct request with options
        // TODO: Implement invite() method.

        //call httpclient and send it
    }

    public function fetchAll(array $options)
    {
        // TODO: Implement fetchAll() method.
    }

    public function find(string $reference)
    {
        // TODO: Implement find() method.
    }
}
