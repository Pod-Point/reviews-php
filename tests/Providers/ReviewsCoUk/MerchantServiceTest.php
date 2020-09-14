<?php

namespace PodPoint\Reviews\Tests;

use \GuzzleHttp\Client as GuzzleClient;
use Illuminate\Config\Repository as Config;
use Mockery;
use PodPoint\Reviews\Providers\ReviewsCoUk\MerchantService;

class MerchantServiceTest extends TestCase
{
    const URL = 'localhost';
    const STORE = 'someStore';
    const API_KEY = 'someApiKey';

    /**
     * @var GuzzleClient|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $mockClient;

    /**
     * @var MerchantService
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

        $config = Mockery::mock(Config::class)->shouldReceive('get')
            ->andReturnUsing(function ($argument)
            {
                switch ($argument)
                {
                    case 'review-providers.reviewsCoUk.url':
                        return self::URL;
                    case 'review-providers.reviewsCoUk.store':
                        return self::STORE;
                    case 'review-providers.reviewsCoUk.api_key':
                        return self::API_KEY;
                }
            })->getMock();

        $this->client = new MerchantService($this->mockClient, $config);
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
            'orderNumber' => $this->faker->uuid,
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
