<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequest;

/**
 * Class EmailInviteRequest
 * @package PodPoint\Reviews\Providers\ReviewsIo\Request\Service
 */
class EmailInviteRequest extends BaseRequest
{
    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $body = \GuzzleHttp\json_encode(
            $this->options + ['store' => $this->getOption('store')]
        );

        return new Request('POST', '/merchant/invitation', [], $body);
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
