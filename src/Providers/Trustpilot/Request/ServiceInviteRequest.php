<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use GuzzleHttp\Exception\GuzzleException;

class ServiceInviteRequest extends BaseInviteRequest
{
    protected $tags;

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
        $this->validateAndSendRequest(
            'POST',
            $this->getEndpoint(),
            [
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
                ]
            ],
            [],
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
