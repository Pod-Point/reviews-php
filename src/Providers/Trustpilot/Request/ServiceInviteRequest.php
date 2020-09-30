<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;


class ServiceInviteRequest extends BaseInviteRequest
{
    protected $tags;

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function send()
    {
        return $this->getResponseJson($this->validateAndSendRequest(
            'POST',
            "{$this->baseInviteUrl}/v1/private/business-units/{$this->businessUnitId}/email-invitations",
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
                ],
            ],
            [],
            true
        ));
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
