<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot;

use GuzzleHttp\ClientInterface;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Providers\Trustpilot\TrustpilotApiClient;
use PodPoint\Reviews\Tests\TestCase;

class TrustpilotApiClientTest extends TestCase
{
    /**
     * Making sure the Trustpilot constructor is setting properties and constructs instance of a valid http client.
     */
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

//    /**
//     * Making sure access token can be grabbed and returned as AccessToken model.
//     */
//    public function testGetAccessToken()
//    {
//        $apiKey = 'api-key-123';
//        $secretKey = 'api-secret-key-123';
//        $username = 'api-username';
//        $password = 'api-password';
//
//        $token = [
//            'access_token' => 'ey12easdwrsyeud6if7gohoji8hp97o68fi',
//            'expires_in' => '3600',
//            'refresh_token' => '0/koiouliykgutjyhethrfjyguktrdyfS3'
//        ];
//
//        $this->getMockedResponse(\GuzzleHttp\json_encode($token));
//
//        $client = new Mocked_TrustpilotApiClient($apiKey, $secretKey, $username, $password);
//
//        $this->assertInstanceOf(AccessToken::class, $client->getAccessToken());
//    }


    public function testSendRequest()
    {
        $apiKey = 'api-key-123';
        $secretKey = 'api-secret-key-123';
        $username = 'api-username';
        $password = 'api-password';

        $token = [
            'access_token' => 'ey12easdwrsyeud6if7gohoji8hp97o68fi',
            'expires_in' => '3600',
            'refresh_token' => '0/koiouliykgutjyhethrfjyguktrdyfS3'
        ];

        $this->getMockedResponse(\GuzzleHttp\json_encode($token));

        $client = new Mocked_TrustpilotApiClient($apiKey, $secretKey, $username, $password);

//        $client->sendRequest()
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
