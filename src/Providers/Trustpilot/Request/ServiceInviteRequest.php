<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequest;

class ServiceInviteRequest extends BaseRequest
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        return new Request(
            'POST',
            "https://invitations-api.trustpilot.com/v1/private/business-units/{$businessUnitId}/email-invitations",
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
        $response = $this->httpClient->sendRequest(
            $this->getRequest(),
            true
        );

        return $this->httpClient->getResponseJson($response);
    }

    /**
     * @return array
     */
    protected function requiredFields(): array
    {
        return [
            'referenceNumber',
            'consumerEmail',
            'consumerName',
        ];
    }
}
