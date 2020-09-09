<?php


namespace PodPoint\Reviews\Tests;

use \GuzzleHttp\Client as GuzzleClient;
use PodPoint\Reviews\Providers\ReviewsCoUk\Configuration;
use PodPoint\Reviews\Providers\ReviewsCoUk\Service;

class ServiceTest extends TestCase
{
    const URL = 'localhost';
    const STORE = 'someStore';
    const API_KEY = 'someApiKey';

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $mockClient;

    /**
     * @var Service
     */
    private $client;

    /**
     * Mocks the config & guzzle client and creates a client instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockClient = $this->createMock(GuzzleClient::class);

        $this->client = new Service($this->mockClient, new Configuration([
            'url' => self::URL,
            'store' => self::STORE,
            'apiKey' => self::API_KEY,
        ]));
    }

    /**
     * Ensure the Service can send invites.
     */
    public function testCanSendInviteToReview()
    {
        $options = [
            'name',
            'email',
            'orderNumber'
        ];

        $this->client->invite();
    }
}
