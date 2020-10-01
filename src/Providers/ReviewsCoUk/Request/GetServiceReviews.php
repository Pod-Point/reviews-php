<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk\Request;

use GuzzleHttp\Psr7\Request;
use \PodPoint\Reviews\Request\BaseRequest;

class GetServiceReviews extends BaseRequest
{
    /**
     * @return array
     */
    protected function requiredFields(): array
    {
        return ['store'];
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        $store = $this->getOption('store');

        return new Request(
            'GET',
            'https://api.reviews.co.uk/merchant/reviews',
            [
                'query' => [
                    'store' => $store,
                ] + $this->options,
            ]
        );
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
