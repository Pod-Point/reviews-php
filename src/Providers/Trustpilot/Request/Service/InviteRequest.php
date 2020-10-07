<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PodPoint\Reviews\Request\BaseRequest;

class InviteRequest extends BaseRequest
{
    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        $method = 'POST';
        $uri = new Uri("https://invitations-api.trustpilot.com/v1/private/business-units/{$businessUnitId}/email-invitations");
        $header = [];
        $body = \GuzzleHttp\json_encode($this->options);

        return new Request($method, $uri, $header, $body);
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

    /**
     * List of required fields.
     *
     * @return array
     */
    public function requiredFields(): array
    {
        return [
            'referenceNumber',
            'consumerEmail',
            'consumerName',
        ];
    }
}
