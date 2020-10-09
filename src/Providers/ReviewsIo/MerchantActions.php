<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\GetMerchantReviews;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\EmailInviteRequest;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\FindReviewRequest;

/**
 * Class MerchantActions
 * @package PodPoint\Reviews\Providers\ReviewsIo
 */
class MerchantActions implements ActionsInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * @var string
     */
    protected $store;

    /**
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
    public function getReviews(array $options = [])
    {
        $options['store'] = $this->store;

        $request = new GetMerchantReviews($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Find reviews by id.
     *
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
     * Sets store id and returns itself.
     *
     * @param string $store
     * @return $this
     */
    public function setStore(string $store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Returns store id.
     *
     * @return string
     */
    public function getStore(): string
    {
        return $this->store;
    }
}
