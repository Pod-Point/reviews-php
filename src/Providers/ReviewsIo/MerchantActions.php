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
     * @var string
     */
    protected $store;

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
}
