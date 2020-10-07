<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

class FindReviewRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function requiredFields(): array
    {
        return [
            'reviewId'
        ];
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        $uri = new Uri('https://api.reviews.co.uk/merchant/reviews');
        $uri = Uri::withQueryValues(
            $uri,
            ['store' => $this->getOption('store'), 'review_id' => $this->getOption('reviewId')]
        );

        return new Request('GET', $uri);
    }

    /**
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
