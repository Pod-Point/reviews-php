<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PodPoint\Reviews\Request\BaseRequest;

class EmailInviteRequest extends BaseRequest
{
    /**
     * Builds the request.
     *
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
     * List of required fields.
     *
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
}
