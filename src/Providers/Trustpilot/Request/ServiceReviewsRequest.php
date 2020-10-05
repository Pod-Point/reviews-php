<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

class ServiceReviewsRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function requiredFields(): array
    {
        return [];
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        $method = 'GET';
        $uri = new Uri("https://api.trustpilot.com/v1/private/business-units/{$businessUnitId}/reviews");
        $uri = Uri::withQueryValues($uri,$this->options);

        return new Request($method, $uri);
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
