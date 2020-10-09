<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

/**
 * Class FindReviewRequest
 * @package PodPoint\Reviews\Providers\ReviewsIo\Request\Service
 */
class FindReviewRequest extends BaseRequest
{
    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $query = http_build_query([
            'store' => $this->getOption('store'),
            'review_id' => $this->getOption('reviewId'),
        ]);

        return new Request('GET', '/merchant/reviews?' . $query);
    }

    /**
     * List of required fields.
     *
     * @return array
     */
    public function requiredFields(): array
    {
        return [
            'reviewId'
        ];
    }

    /**
     * Sends the request and parses response into array.
     *
     * @return array|mixed
     */
    public function send()
    {
        $response = $this->httpClient->sendRequest(
            $this->getRequest(),
            true
        );

        return $this->httpClient->getResponseJson($response);
    }
}
