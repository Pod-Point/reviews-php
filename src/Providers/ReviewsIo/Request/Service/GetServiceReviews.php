<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

class GetServiceReviews extends BaseRequest
{
    /**
     * List of required fields.
     *
     * @return array
     */
    public function requiredFields(): array
    {
        return ['store'];
    }

    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $store = $this->getOption('store');

        $uri = new Uri('https://api.reviews.co.uk/merchant/reviews');
        $uri = Uri::withQueryValues($uri, $this->options + ['store' => $store]);

        return new Request('GET', $uri);
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
