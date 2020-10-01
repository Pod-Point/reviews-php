<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk\Request;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequest;

class SendServiceInvite extends BaseRequest
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return new Request(
            'POST',
            'https://api.reviews.co.uk/merchant/invitation',
            [
                'form_params' => $this->options,
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
            'name',
            'email',
            'order_id',
            'store',
        ];
    }
}
