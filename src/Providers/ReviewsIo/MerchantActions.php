<?php

namespace PodPoint\Reviews\Providers\ReviewsIo;

use PodPoint\Reviews\ActionsInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\EmailInviteRequest;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\FindReviewRequest;
use PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant\GetMerchantReviews;

/**
 * Class MerchantActions.
 */
class MerchantActions implements ActionsInterface
{
    /**
     * Api Client.
     *
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * Provider config.
     *
     * @var array
     */
    protected $config;

    /**
     * ServiceReview constructor.
     *
     * @param ApiClientInterface $apiClient
     * @param array $config
     */
    public function __construct(ApiClientInterface $apiClient, array $config)
    {
        $this->apiClient = $apiClient;
        $this->config = $config;
    }

    /**
     * Sends out review invite email.
     *
     * @param array $options
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['store'] = $this->config['store'];

        $request = new EmailInviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Get all reviews, with filter if $options specified.
     *
     * @param array $options
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function getReviews(array $options = [])
    {
        $options['store'] = $this->config['store'];

        $request = new GetMerchantReviews($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Find review by id.
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
            'store' => $this->config['store'],
        ];

        $request = new FindReviewRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Find review by order number.
     *
     * @param string $orderNumber
     *
     * @return array|mixed
     * @throws ValidationException
     */
    public function findReviewByOrderNumber(string $orderNumber)
    {
        $options = [
            'orderNumber' => $orderNumber,
            'store' => $this->config['store'],
        ];

        $request = new FindReviewRequest($this->apiClient, $options);

        return $request->send();
    }
}
