<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\FindReviewRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\InviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\GetReviewsRequest;
use PodPoint\Reviews\ActionsInterface;

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
     * MerchantActions constructor.
     * @param ApiClientInterface $apiClient
     * @param array $config
     */
    public function __construct(ApiClientInterface $apiClient, array $config)
    {
        $this->apiClient = $apiClient;
        $this->config = $config;
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
        $requiredOptions = [
            'businessUnitId' => $this->config['business_unit_id'],
            'redirectUri' => $this->config['invite_redirect_uri'],
            'replyTo' => $this->config['invite_reply_to_email'],
        ];

        $options = $options + $requiredOptions;

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
        $options['businessUnitId'] = $this->config['business_unit_id'];
        $request = new GetReviewsRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * Find reviews by id.
     *
     * @param array $options
     *
     * @return mixed
     * @throws ValidationException
     */
    public function findReview(array $options)
    {
        $request = new FindReviewRequest($this->apiClient, $options);

        return $request->send();
    }
}
