<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

abstract class InviteOptions
{
    const DEFAULT_SENDER_EMAIL = 'noreply.invitations@trustpilotmail.com';

    /**
     * The email address you would like to send the invite to.
     *
     * @var string
     */
    public string $consumerEmail;

    /**
     * The name of the person you would like to send the invite to.
     *
     * @var string
     */
    public string $consumerName;

    /**
     * The locale of the person you would like to send the invite to.
     *
     * @var string
     */
    public string $locale;

    /**
     * The reference number for the invite.
     *
     * @var string
     */
    public string $referenceNumber;

    /**
     * The email address you would like reply emails to go to.
     *
     * @var string
     */
    public string $replyTo;

    /**
     * The email address you would like to use as the invitation sender.
     *
     * @var string
     */
    public string $senderEmail;

    /**
     * The name you would like to use as the invitation sender.
     *
     * @var string
     */
    public string $senderName;

    /**
     * Sets all the invite options from the given array.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->consumerEmail = $options['consumerEmail'];
        $this->consumerName = $options['consumerName'];
        $this->locale = $options['locale'];
        $this->referenceNumber = $options['referenceNumber'];
        $this->replyTo = $options['replyTo'];
        $this->senderEmail = $options['senderEmail'] ?? self::DEFAULT_SENDER_EMAIL;
        $this->senderName = $options['senderName'];
    }
}
