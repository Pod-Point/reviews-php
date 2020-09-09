<?php


namespace PodPoint\Reviews\Tests;

use \GuzzleHttp\Client as GuzzleClient;
use Mockery;
use PodPoint\Reviews\Providers\ReviewsCoUk\Configuration;
use PodPoint\Reviews\Providers\ReviewsCoUk\Service;

class ServiceTest extends TestCase
{
    const URL = 'localhost';
    const STORE = 'someStore';
    const API_KEY = 'someApiKey';

    /**
     * @var GuzzleClient|Mockery\LegacyMockInterface|Mockery\MockInterface
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

        $this->mockClient = Mockery::mock(GuzzleClient::class);

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
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'orderNumber' => $this->faker->randomNumber(),
        ];

        $this->mockClient
            ->shouldReceive('request')
            ->with( 'POST',
                'merchant/invitation',
                Mockery::subset(['base_uri' => self::URL])
//                Mockery::subset(['form_params' => Mockery::contains(['name' => $options['name']])])
            )->once();

//, , $this->returnValue(array()), $this->returnValue(array())
        $this->client->invite($options);
    }
}
