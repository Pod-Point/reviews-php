<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request\Merchant;

use GuzzleHttp\Psr7\Request;
use PodPoint\Reviews\Request\BaseRequestWrapper;

/**
 * Class InviteRequest.
 */
class InviteRequest extends BaseRequestWrapper
{
    /**
     * The base invitation URL, this different the base URL the ApiClient has, it will be override the
     * ApiClient baseUri;
     *
     * @var string
     */
    protected $baseUri = 'https://invitations-api.trustpilot.com';

    /**
     * Builds the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        $businessUnitId = $this->getOption('businessUnitId');

        $preferredSendTime = isset($this->options['preferredSendTime']) ?
            $this->options['preferredSendTime'] : (new \DateTime())->format('m/d/Y h:i:s a');

        $this->options['serviceReviewInvitation'] = [
            'preferredSendTime' => $preferredSendTime,
            'redirectUri' => $this->options['redirectUri'],
            'replyTo' => $this->options['replyTo'],
        ];

        $uri = "{$this->baseUri}/v1/private/business-units/{$businessUnitId}/email-invitations";
        $body = \GuzzleHttp\json_encode($this->options);

        return new Request('POST', $uri, [], $body);
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
            $this->withAuthentication
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
            'businessUnitId',
        ];
    }
}
