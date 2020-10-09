<?php

namespace PodPoint\Reviews\Providers\ReviewsIo\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use \PodPoint\Reviews\Request\BaseRequest;

/**
 * Class GetMerchantReviews
 * @package PodPoint\Reviews\Providers\ReviewsIo\Request\Service
 */
class GetMerchantReviews extends BaseRequest
{
    /**
     * List of required fields.
     *
     * @return array
     */
    public function requiredFields(): array
    {
        return ['store'];
    }

    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $store = $this->getOption('store');

        $query = http_build_query($this->options + ['store' => $store]);

        return new Request('GET', '/merchant/reviews?' . $query);
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
