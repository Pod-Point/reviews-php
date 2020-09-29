<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Exception\GuzzleException;

class ServiceInviteRequest extends BaseInviteRequest
{
    protected $tags;

    public function getEndpoint()
    {
        return "https://invitations-api.trustpilot.com/v1/private/business-units/{$this->businessUnitId}/email-invitations";
    }

    public function setRequestTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed|void
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     * @throws GuzzleException
     */
    public function send()
    {
        $this->httpClient->request('POST',
            $this->getEndpoint(),
            $this->getRequestPayload()
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

    /**
     * @return array
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     * @throws GuzzleException
     */
    protected function getRequestPayload(): array
    {
        $this->validate();
        $accessToken = $this->getAccessToken();

        $request = [
            'headers' => [
                'authorization' => "Bearer {$accessToken->accessToken}",
            ],
            'json' => [
                'consumerEmail' => $this->consumerEmail,
                'consumerName' => $this->consumerName,
                'locale' => $this->locale,
                'locationId' => $this->locationId,
                'referenceNumber' => $this->referenceNumber,
                'replyTo' => $this->replyTo,
                'senderEmail' => $this->senderEmail,
                'senderName' => $this->senderName,
                'serviceReviewInvitation' => [
                    'preferredSendTime' => $this->preferredSendTime,
                    'redirectUri' => $this->redirectUri,
                    'tags' => $this->tags,
                    'templateId' => $this->templateId,
                ],
            ],
        ];

        return $request;
    }
}
