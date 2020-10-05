<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\FindReviewRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\InviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\GetReviewsRequest;
use PodPoint\Reviews\ActionsInterface;

/**
 * Class ServiceActions
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class ServiceActions implements ActionsInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /***
     * @var string
     */
    protected $businessUnitId;

    /**
     * ServiceActions constructor.
     * @param ApiClientInterface $apiClient
     */
    public function __construct(ApiClientInterface $apiClient)
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
        $request = new InviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function getReviews(array $options)
    {
        $options['businessUnitId'] = $this->businessUnitId;
        $request = new GetReviewsRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param string $reviewId
     * @return array|mixed
     */
    public function findReview(string $reviewId)
    {
        $options = [
            'reviewId' => $reviewId,
        ];

        $request = new FindReviewRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param $businessUnitId
     * @return $this
     */
    public function setBusinessUnitId(string $businessUnitId): ServiceActions
    {
        $this->businessUnitId = $businessUnitId;

        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessUnitId()
    {
        return $this->businessUnitId;
    }
}
