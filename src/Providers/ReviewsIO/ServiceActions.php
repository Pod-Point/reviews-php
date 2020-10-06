<?php

namespace PodPoint\Reviews\Providers\ReviewsIO;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\ReviewsIO\Request\GetServiceReviews;
use PodPoint\Reviews\Providers\ReviewsIO\Request\EmailInviteRequest;
use PodPoint\Reviews\Providers\ReviewsIO\Request\Service\FindReviewRequest;

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
    public function __construct(ReviewsCoUkApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param array $options
     * @return array|mixed
     */
    public function invite(array $options)
    {
        $options['store'] = $this->store;

        $request = new EmailInviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
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
     * @return array|mixed
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
}
