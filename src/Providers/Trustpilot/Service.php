<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use PodPoint\Reviews\Service as ServiceInterface;
use Psr\Http\Message\ResponseInterface;

class Service implements ServiceInterface
{
    /**
     * A HTTP client instance.
     *
     * @var Client
     */
    private $client;

    /**
     * A Trustpilot configuration instance.
     *
     * @var AuthenticationConfiguration
     */
    private $authConfig;

    /**
     * A Trustpilot configuration instance.
     *
     * @var InviteConfiguration
     */
    private $inviteConfiguration;

    /**
     * A Trustpilot api domain.
     *
     * @var string
     */
    private $apiDomain;

    /**
     * The Trustpilot business unit ID.
     *
     * @var string
     */
    public $businessUnitId;

    /**
     * Sets the client and configuration for the service.
     *
     * @param Client $client
     * @param AuthenticationConfiguration $authConfig
     * @param InviteConfiguration $inviteConfig
     * @param Config $config
     */
    public function __construct(
        Client $client,
        AuthenticationConfiguration $authConfig,
        InviteConfiguration $inviteConfig,
        Config $config
    ) {
        $this->client = $client;
        $this->authConfig = $authConfig;
        $this->inviteConfiguration = $inviteConfig;
        $this->businessUnitId = $config->get('review-providers.providers.trustpilot.businessUnitId');
    }

    /**
     * Creates an invite.
     *
     * @inheritdoc
     */
    public function sendOrderReviewInvite(string $email, string $name, string $orderId): void
    {
        $accessToken = $this->getAccessToken();

        $this->client->post("https://invitations-api.trustpilot.com/v1/private/business-units/{$this->businessUnitId}/email-invitations",
            [
                'headers' => [
                    'authorization' => "Bearer {$accessToken->accessToken}",
                ],
                'json' => [
                    'consumerEmail' => $email,
                    'consumerName' => $name,
                    'locale' => $this->inviteConfiguration->locale,
                    'referenceNumber' => $orderId,
                    'replyTo' => $this->inviteConfiguration->replyTo,
                    'senderEmail' => $this->inviteConfiguration->senderEmail,
                    'senderName' => $this->inviteConfiguration->senderName,
                    'serviceReviewInvitation' => [
                        'redirectUri' => $this->inviteConfiguration->redirectUri,
                        'templateId' => $this->inviteConfiguration->templateId,
                    ],
                ],
            ]);
    }

    /**
     * Get the company reviews between dates.
     *
     * @inheritdoc
     */
    public function getCompanyReviewsBetweenDates(string $from = null, string $to = null): ?array
    {
        $response = $this->client->get(
            "https://api.trustpilot.com/v1/private/business-units/{$this->businessUnitId}/reviews",
            [
                'params' => [
                    'startDateTime' => $from,
                    'endDateTime' => $to,
                ],
            ]
        );

        return $this->getResponseJson($response);
    }

    /**
     * Get the company review for an order.
     *
     * @inheritdoc
     */
    public function getOrderReview(string $orderId): ?array
    {
        $response = $this->client->get(
            "https://api.trustpilot.com/v1/private/business-units/{$this->businessUnitId}/reviews",
            [
                'params' => [
                    'referenceId' => $orderId,
                ],
            ]
        );

        return $this->getResponseJson($response);
    }

    /**
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     */
    protected function getAccessToken(): AccessToken
    {
        $key = base64_encode("{$this->authConfig->apiKey}:{$this->authConfig->secretKey}");

        $response = $this->client->post("{$this->apiDomain}/oauth/oauth-business-users-for-applications/accesstoken",
            [
                'headers' => [
                    'authorization' => "Basic {$key}",
                ],
                'form_params' => [
                    'grant_type' => 'password',
                    'password' => $this->authConfig->password,
                    'username' => $this->authConfig->username,
                ],
            ]);

        $json = $this->getResponseJson($response);

        return new AccessToken($json);
    }

    /**
     * Retrieves the JSON from a HTTP response.
     *
     * @param ResponseInterface $response
     * @return array
     */
    private function getResponseJson(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();

        return \GuzzleHttp\json_decode($body, true);
    }
}
