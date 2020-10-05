<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PodPoint\Reviews\Request\BaseRequest;

class ServiceInviteRequest extends BaseRequest
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        $method = 'POST';
        $uri = new Uri("https://invitations-api.trustpilot.com/v1/private/business-units/{$businessUnitId}/email-invitations");
        $header = [];
        $body = json_encode($this->options);

        return new Request($method, $uri, $header, $body);
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

    /**
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
