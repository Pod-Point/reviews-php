<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\ServiceInviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\ServiceReviewsRequest;
use PodPoint\Reviews\ReviewsInterface;


class ServiceReview implements ReviewsInterface
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new TrustpilotApiClient();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $request = new ServiceInviteRequest($this->httpClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function fetchAll(array $options)
    {
        $request = new ServiceReviewsRequest($this->httpClient, $options);

        return $request->send();
    }

    /**
     * @param string $reference
     * @return array|mixed
     * @throws ValidationException
     */
    public function find(string $reference)
    {
        $options = [
            'referenceId' => $reference
        ];

        $request = new ServiceReviewsRequest($this->httpClient, $options);

        return $request->send();
    }
}
