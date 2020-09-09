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
     * @var Mockery\LegacyMockInterface|Mockery\MockInterface|response
     */
    private $response;

    /**
     * Mocks the config & guzzle client and creates a client instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockClient = Mockery::mock(GuzzleClient::class);

        $this->response = Mockery::mock('response');

        $this->client = new Service($this->mockClient, new Configuration([
            'url' => self::URL,
            'store' => self::STORE,
            'apiKey' => self::API_KEY,
        ]));
    }

    /**
     * Ensure the Service can prepare a request to send invites to review.
     *
     * @doesNotPerformAssertions
     */
    public function testCanPrepareARequestToSendInviteToReview()
    {
        $options = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'orderNumber' => $this->faker->randomNumber(),
        ];

        $this->mockClient
            ->shouldReceive('request')
            ->with('POST',
                'merchant/invitation',
                Mockery::subset(['base_uri' => self::URL])
            )->once();

        $this->client->invite($options);
    }

    /**
     * Ensure the Service can prepare a request to get reviews.
     */
    public function testCanPrepareARequestToGetReviewsForAnOrder()
    {
        $options = [
            'orderNumber' => $this->faker->name,
        ];

        $testData = $this->faker->text;

        $this->response->shouldReceive('getBody')->andReturn($this->response)->once();
        $this->response
            ->shouldReceive('getContents')
            ->andReturn(json_encode($testData))
            ->once();

        $this->mockClient
            ->shouldReceive('request')
            ->with( 'GET',
                'merchant/reviews',
                Mockery::subset(['base_uri' => self::URL])
            )->andReturn($this->response)->once();

        $response = $this->client->get($options);
        $this->assertEquals($testData, $response);
    }
}
