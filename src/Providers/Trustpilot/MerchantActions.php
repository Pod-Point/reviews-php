<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\FindReviewRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\InviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\GetReviewsRequest;
use PodPoint\Reviews\ActionsInterface;

/**
 * Class MerchantActions
 * @package PodPoint\Reviews\Providers\Trustpilot
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
    protected $merchantId;

    /**
     * MerchantActions constructor.
     * @param ApiClientInterface $apiClient
     */
    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Invite consumers.
     *
     * @param array $options
     * @return mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['businessUnitId'] = $this->merchantId;
        $request = new InviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Get reviews.
     *
     * @param array $options
     *
     * @return mixed
     * @throws ValidationException
     */
    public function getReviews(array $options = [])
    {
        $options['businessUnitId'] = $this->merchantId;
        $request = new GetReviewsRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Find reviews by id.
     *
     * @param string $reviewId
     *
     * @return mixed
     * @throws ValidationException
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
     * Sets merchant id which is equivalent to business unit id and returns itself.
     *
     * @param $merchantId
     * @return $this
     */
    public function setMerchantId(string $merchantId): MerchantActions
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Returns merchant id which is equivalent business unit id.
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
}
