<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequestWrapper;

/**
 * Class FindReviewRequest.
 */
class FindReviewRequest extends BaseRequestWrapper
{
    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $options = [
            'store' => $this->getOption('store'),
        ];

        if ($this->getOption('review_id')) {
            $options['review_id'] = $this->getOption('review_id');
        }

        if ($this->getOption('order_number')) {
            $options['order_number'] = $this->getOption('order_number');
        }

        $query = http_build_query($options);

        return new Request('GET', '/merchant/reviews?' . $query);
    }

    /**
     * List of required fields.
     *
     * @return array
     */
    public function requiredFields(): array
    {
        return [];
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
