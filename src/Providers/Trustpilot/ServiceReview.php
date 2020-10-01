<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\ServiceInviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\ServiceReviewsRequest;
use PodPoint\Reviews\ReviewsInterface;

class ServiceReview implements ReviewsInterface
{
    /**
     * @var TrustpilotApiClient
     */
    protected $apiClient;

    /***
     * @var string
     */
    protected $businessUnitId;

    /***
     * ServiceReview constructor.
     *
     * @param $apiClient
     */
    public function __construct(TrustpilotApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['businessUnitId'] = $this->businessUnitId;
        $request = new ServiceInviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function fetchAll(array $options)
    {
        $options['businessUnitId'] = $this->businessUnitId;
        $request = new ServiceReviewsRequest($this->apiClient, $options);

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
            'referenceId' => $reference,
            'businessUnitId' => $this->businessUnitId,
        ];

        $request = new ServiceReviewsRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param $businessUnitId
     * @return $this
     */
    public function setBusinessUnitId(string $businessUnitId): ServiceReview
    {
        $this->businessUnitId = $businessUnitId;

        return $this;
    }
}
