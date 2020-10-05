<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use GuzzleHttp\ClientInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\Trustpilot\TrustpilotApiClient;
use PodPoint\Reviews\Tests\TestCase;

class TrustpilotApiClientTest extends TestCase
{
    public function testConstruct()
    {
        $apiKey = 'api-key-123';
        $secretKey = 'api-secret-key-123';
        $username = 'api-username';
        $password = 'api-password';

        $apiClient = new Mocked_TrustpilotApiClient($apiKey, $secretKey, $username, $password);

        $this->assertInstanceOf(ApiClientInterface::class, $apiClient);

        $this->assertEquals($apiKey, $apiClient->getApiKey());
        $this->assertEquals($secretKey, $apiClient->getSecretKey());
        $this->assertEquals($username, $apiClient->getUsername());
        $this->assertEquals($password, $apiClient->getPassword());

        $this->assertInstanceOf(ClientInterface::class, $apiClient->getHttpClient());
    }

    /**
     * Making sure access token can be grabbed and returned as AccessToken model.
     */
    public function testGetAccessToken()
    {
        $apiKey = 'api-key-123';
        $secretKey = 'api-secret-key-123';
        $username = 'api-username';
        $password = 'api-password';

        $client = new Mocked_TrustpilotApiClient($apiKey, $secretKey, $username, $password);
    }
}


class Mocked_TrustpilotApiClient extends TrustpilotApiClient {

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
