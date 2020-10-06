<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PodPoint\Reviews\Request\BaseRequest;

class InviteRequest extends BaseRequest
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        $store = $this->getOption('store');

        $uri = new Uri('https://api.reviews.co.uk/merchant/invitation');
        $header = [];
        $body = \GuzzleHttp\json_encode($this->options + ['store' => $store]);

        return new Request('POST', $uri, $header, $body);
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
            'name',
            'email',
            'order_id',
            'store',
        ];
    }
}
