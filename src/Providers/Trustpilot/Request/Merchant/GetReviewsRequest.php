<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PodPoint\Reviews\Request\BaseRequestWrapper;

/**
 * Class GetReviewsRequest.
 */
class GetReviewsRequest extends BaseRequestWrapper
{
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
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        $uri = new Uri("https://api.trustpilot.com/v1/private/business-units/{$businessUnitId}/reviews");
        $uri = Uri::withQueryValues($uri, $this->options);

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
