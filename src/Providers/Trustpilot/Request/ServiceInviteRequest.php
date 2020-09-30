<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ServiceInviteRequest extends BaseRequest
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return new Request(
            'POST',
            "https://invitations-api.trustpilot.com/v1/private/business-units/{$this->getOption('businessUnitId')}/email-invitations",
            [
                'json' => $this->options,
            ]
        );
    }

    public function send(): Response
    {
        return $this->httpClient->validateAndSend(
            $this->getRequest(),
            true
        );
    }

    /**
     * @return array
     */
    protected function requiredFields(): array
    {
        return [
            'businessUnitId',
            'consumerEmail',
            'consumerName',
        ];
    }
}
