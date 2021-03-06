<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequestWrapper;

/**
 * Class FindReviewRequest.
 */
class FindReviewRequest extends BaseRequestWrapper
{
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
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $uri = "/v1/private/reviews/{$this->getOption('reviewId')}";

        return new Request('GET', $uri);
    }

    /**
     * Sends the request and parses response into array.
     *
     * @return array|mixed
     */
    public function send()
    {
        $response = $this->apiClient->sendRequest(
            $this->getRequest(),
            $this->withAuthentication
        );

        return $this->apiClient->getResponseJson($response);
    }
}
