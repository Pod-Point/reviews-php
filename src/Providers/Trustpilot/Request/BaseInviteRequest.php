<?php

namespace PodPoint\Reviews\Providers\Trustpilot\Request;

use PodPoint\Reviews\Providers\Trustpilot\AbstractTrustpilotApiClient;

abstract class BaseInviteRequest extends AbstractTrustpilotApiClient
{
    protected $businessUnitId;
    protected $consumerEmail;
    protected $consumerName;
    protected $preferredSendTime;
    protected $redirectUri;
    protected $templateId;
    protected $referenceNumber;
    protected $locale;
    protected $locationId;
    protected $replyTo;
    protected $senderEmail;
    protected $senderName;

    public function getEndpoint()
    {
        return "https://invitations-api.trustpilot.com/v1/private/business-units/{$this->businessUnitId}/email-invitations";
    }

    public function setBusinessId(string $businessId): void
    {
        $this->businessUnitId = $businessId;
    }

    public function setConsumerEmail(string $consumerEmail): void
    {
        $this->consumerEmail = $consumerEmail;
    }

    public function setConsumerName(string $consumerName): void
    {
        $this->consumerName = $consumerName;
    }

    public function setPreferredSendTime(string $preferredSendTime): void
    {
        $this->preferredSendTime = $preferredSendTime;
    }

    public function setRedirectUrl(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    public function setTemplateId(string $templateId): void
    {
        $this->templateId = $templateId;
    }

    public function setReferenceNumber(string $referenceNumber): void
    {
        $this->referenceNumber = $referenceNumber;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    public function setReplyTo(string $replyTo): void
    {
        $this->replyTo = $replyTo;
    }

    public function setSenderEmail(string $senderEmail): void
    {
        $this->senderEmail = $senderEmail;
    }

    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }
}
