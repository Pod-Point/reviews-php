<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\Providers\Trustpilot\Request\ServiceInviteRequest;
use PodPoint\Reviews\ReviewsInterface;


class ServiceReview implements ReviewsInterface
{
    /**
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function invite(array $options)
    {
        $request = new ServiceInviteRequest($options);

        return $request->send();
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
