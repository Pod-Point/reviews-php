<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\ReviewsCoUk\Request\GetServiceReviews;
use PodPoint\Reviews\Providers\ReviewsCoUk\Request\SendServiceInvite;
use PodPoint\Reviews\ReviewsInterface;

class ServiceReview implements ReviewsInterface
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
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['store'] = $this->store;

        $request = new SendServiceInvite($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function fetchAll(array $options)
    {
        $options['store'] = $this->store;

        $request = new GetServiceReviews($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param string $orderId
     * @return array|mixed
     * @throws ValidationException
     */
    public function find(string $orderId)
    {
        $options = [
            'order_id' => $orderId,
            'store' => $this->store,
        ];

        $request = new GetServiceReviews($this->apiClient, $options);

        return $request->send();
    }
}
