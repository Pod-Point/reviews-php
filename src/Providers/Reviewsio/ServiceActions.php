<?php

namespace PodPoint\Reviews\Providers\Reviewsio;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Reviewsio\Request\Service\GetServiceReviews;
use PodPoint\Reviews\Providers\Reviewsio\Request\Service\EmailInviteRequest;
use PodPoint\Reviews\Providers\Reviewsio\Request\Service\FindReviewRequest;

class ServiceActions implements ActionsInterface
{
    /**
     * @var ReviewsCoUkApiClient
     */
    protected $apiClient;

    /***
     * @var string
     */
    protected $store;

    /***
     * ServiceReview constructor.
     *
     * @param $apiClient
     */
    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param array $options
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['store'] = $this->store;

        $request = new EmailInviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function getReviews(array $options)
    {
        $options['store'] = $this->store;

        $request = new GetServiceReviews($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param string $reviewId
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function findReview(string $reviewId)
    {
        $options = [
            'reviewId' => $reviewId,
            'store' => $this->store,
        ];

        $request = new FindReviewRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param string $store
     * @return $this
     */
    public function setStore(string $store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return string
     */
    public function getStore(): string
    {
        return $this->store;
    }
}
