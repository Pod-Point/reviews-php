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
    private Client $client;

    /**
     * A Trustpilot configuration instance.
     *
     * @var Configuration
     */
    private Configuration $config;

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
    }

    /**
     * Creates an invite.
     *
     * @param array $options
     */
    public function invite(array $options)
    {
        $options = new ServiceInviteOptions($options);

        $accessToken = $this->getAccessToken();

        $response = $this->client->post("https://invitations-api.trustpilot.com/v1/private/business-units/{$this->config->businessUnitId}/email-invitations", [
            'headers' => [
                'authorization' => "Bearer {$accessToken->accessToken}",
            ],
            'json' => [
                'consumerEmail' => $options->consumerEmail,
                'consumerName' => $options->consumerName,
                'locale' => $options->locale,
                'referenceNumber' => $options->referenceNumber,
                'replyTo' => $options->replyTo,
                'senderEmail' => $options->senderEmail,
                'senderName' => $options->senderName,
                'serviceReviewInvitation' => [
                    'preferredSendTime' => $options->preferredSendTime,
                    'redirectUri' => $options->redirectUri,
                    'tags' => $options->tags,
                    'templateId' => $options->templateId,
                ],
            ],
        ]);

        var_dump($response);
    }

    /**
     * Retrieves an OAuth2 access token.
     *
     * @return AccessToken
     */
    protected function getAccessToken(): AccessToken
    {
        $key = base64_encode("{$this->config->apiKey}:{$this->config->secretKey}");

        $response = $this->client->post('https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications/accesstoken', [
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

        var_dump($json);

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
