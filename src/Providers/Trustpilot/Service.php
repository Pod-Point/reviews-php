<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use GuzzleHttp\Client;
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
     * @var Configuration
     */
    private $config;

    /**
     * A Trustpilot api domain.
     *
     * @var string
     */
    private $apiDomain;

    /**
     * Sets the client and configuration for the service.
     *
     * @param Client $client
     * @param Configuration $config
     */
    public function __construct(Client $client, Configuration $config)
    {
        $this->client = $client;
        $this->config = $config;
        $this->apiDomain = 'https://invitations-api.trustpilot.com/v1';
    }

    /**
     * Creates an invite.
     *
     * @inheritdoc
     */
    public function sendOrderReviewInvite(string $email, string $name, string $orderId): void
    {
        $accessToken = $this->getAccessToken();

        $this->client->post("{$this->apiDomain}/private/business-units/{$this->config->businessUnitId}/email-invitations",
            [
                'headers' => [
                    'authorization' => "Bearer {$accessToken->accessToken}",
                ],
                'json' => [
                    'consumerEmail' => $email,
                    'consumerName' => $name,
                    'locale' => $this->config->locale,
                    'referenceNumber' => $orderId,
                    'replyTo' => $this->config->replyTo,
                    'senderEmail' => $this->config->senderEmail,
                    'senderName' => $this->config->senderName,
                    'serviceReviewInvitation' => [
                        'redirectUri' => $this->config->redirectUri,
                        'templateId' => $this->config->templateId,
                    ],
                ],
            ]);
    }

    public function getCompanyReviewsBetweenDates(string $from = null, string $to = null): ?array
    {
        // TODO: Implement getCompanyReviewsBetweenDates() method.
    }

    public function getOrderReview(string $orderId): ?array
    {
        // TODO: Implement getOrderReview() method.
    }

    /**
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     */
    protected function getAccessToken(): AccessToken
    {
        $key = base64_encode("{$this->config->apiKey}:{$this->config->secretKey}");

        $response = $this->client->post("{$this->apiDomain}/oauth/oauth-business-users-for-applications/accesstoken",
            [
                'headers' => [
                    'authorization' => "Basic {$key}",
                ],
                'form_params' => [
                    'grant_type' => 'password',
                    'password' => $this->config->password,
                    'username' => $this->config->username,
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
