<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use \PodPoint\Reviews\Request\BaseRequest;

class ServiceReviewsRequest extends BaseRequest
{

    /**
     * @return array
     */
    protected function requiredFields(): array
    {
        return [];
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return new Request(
            'GET',
            'https://api.trustpilot.com/v1/private/business-units/' . config('review-providers.providers.trustpilot.business_id') . '/reviews',
            [
                'json' => $this->options,
            ]
        );
    }

    /**
     * @return array|mixed
     */
    public function send()
    {
        $response = $this->httpClient->validateAndSend(
            $this->getRequest(),
            true
        );

        return $this->httpClient->getResponseJson($response);
    }
}
