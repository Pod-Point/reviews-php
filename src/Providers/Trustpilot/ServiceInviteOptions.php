<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

class ServiceInviteOptions extends InviteOptions
{
    /**
     * The preferred time you would like to send the invite.
     *
     * @var string
     */
    public string $preferredSendTime;

    /**
     * The redirect URI for the invitation.
     *
     * @var string
     */
    public string $redirectUri;

    /**
     * The tags you would like associated to the review.
     *
     * @var string[]
     */
    public array $tags;

    /**
     * The ID of the template you would like to use for the invitation.
     *
     * @var string
     */
    public string $templateId;

    /**
     * Sets the service invite options from the given array.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->preferredSendTime = $options['preferredSendTime'];
        $this->redirectUri = $options['redirectUri'];
        $this->tags = $options['tags'] ?? [];
        $this->templateId = $options['templateId'];
    }
}
