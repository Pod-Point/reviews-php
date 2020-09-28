<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use Illuminate\Support\Facades\Config;

class InviteConfiguration
{
    /**
     * The locale.
     *
     * @var string
     */
    public $locale;

    /**
     * The email that should be sent to reply to.
     *
     * @var string
     */
    public $replyTo;

    /**
     * The sender email.
     *
     * @var string
     */
    public $senderEmail;

    /**
     * The sender name.
     *
     * @var string
     */
    public $senderName;

    /**
     * The redirect uri used once the review is made.
     *
     * @var string
     */
    public $redirectUri;

    /**
     * The email template id.
     *
     * @var string
     */
    public $templateId;

    /**
     * Sets all the configuration from the given array.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $baseConfig = 'review-providers.providers.trustpilot.invite';

        $this->locale = $config->get("$baseConfig.locale");
        $this->replyTo = $config->get("$baseConfig.replyTo");
        $this->senderEmail = $config->get("$baseConfig.senderEmail");
        $this->senderName = $config->get("$baseConfig.senderName");
        $this->redirectUri = $config->get("$baseConfig.redirectUri");
        $this->templateId = $config->get("$baseConfig.templateId");
    }
}
