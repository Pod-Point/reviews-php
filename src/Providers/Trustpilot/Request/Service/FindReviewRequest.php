<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

class FindReviewRequest extends BaseRequest
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
        $method = 'GET';
        $uri = new Uri("https://api.trustpilot.com/v1/private/reviews/{$this->getOption('reviewId')}");

        return new Request($method, $uri);
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
