<?php

namespace PodPoint\Reviews\Tests;

use Carbon\Carbon;
use \GuzzleHttp\Client as GuzzleClient;
use Illuminate\Config\Repository as Config;
use Mockery;
use PodPoint\Reviews\Providers\ReviewsIo\MerchantService;

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

        $config = Mockery::mock(Config::class)
            ->shouldReceive('get')
            ->andReturnUsing(function ($argument) {
                switch ($argument) {
                    case 'review-providers.providers.reviews_co_uk.url':
                        return self::URL;
                    case 'review-providers.providers.reviews_co_uk.store':
                        return self::STORE;
                    case 'review-providers.providers.reviews_co_uk.api_key':
                        return self::API_KEY;
                }
            })
            ->getMock();

        $this->client = new MerchantService($this->mockClient, $config);
    }

    /**
     * Ensure the Service can prepare a request to send invites to review.
     *
     * @doesNotPerformAssertions
     */
    public function testCanPrepareARequestToSendInviteToReview()
    {
        $this->mockClient
            ->shouldReceive('request')
            ->with('POST',
                'merchant/invitation',
                Mockery::subset(['base_uri' => self::URL])
            )->once();

        $this->client->sendOrderReviewInvite($this->faker->name, $this->faker->email, $this->faker->randomNumber());
    }

    /**
     * Ensure the Service can prepare a request to get reviews.
     */
    public function testCanPrepareARequestToGetReviewsForAnOrder()
    {
        $responseData = ['text' => $this->faker->text];

        $this->response->shouldReceive('getBody')->andReturn($this->response)->once();
        $this->response
            ->shouldReceive('getContents')
            ->andReturn(json_encode($responseData))
            ->once();

        $this->mockClient
            ->shouldReceive('request')
            ->with('GET',
                'merchant/reviews',
                Mockery::subset(['base_uri' => self::URL])
            )
            ->andReturn($this->response)
            ->once();

        $response = $this->client->getOrderReview($this->faker->uuid);
        $this->assertEquals($responseData, $response);
    }

    /**
     * Ensure the service can prepare a request to get reviews between dates.
     */
    public function testCanPrepareARequestToGetReviewsBetweenDates()
    {
        $from = Carbon::now()->subMonth(1);
        $to = Carbon::now();
        $responseData = ['text' => $this->faker->text];

        $this->response->shouldReceive('getBody')->andReturn($this->response)->once();
        $this->response
            ->shouldReceive('getContents')
            ->andReturn(json_encode($responseData))
            ->once();

        $this->mockClient
            ->shouldReceive('request')
            ->with('GET',
                'merchant/reviews',
                Mockery::subset(['base_uri' => self::URL])
            )
            ->andReturn($this->response)
            ->once();

        $response = $this->client->getCompanyReviewsBetweenDates($from->toDateTimeString(), $to->toDateTimeString());
        $this->assertEquals($responseData, $response);
    }
}
