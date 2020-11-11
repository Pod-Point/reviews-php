<?php

namespace PodPoint\Reviews\Tests;

use Mockery;
use PodPoint\Reviews\AbstractApiClient;
use PodPoint\Reviews\Request\AbstractBaseRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class TestCase
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Mocks a review provider class.
     *
     * @param string $provider
     */
    public function mockReviewProviderProvider(string $provider): void
    {
        Mockery::mock("alias:PodPoint\\Reviews\\Providers\\{$provider}\\Provider", 'PodPoint\\Reviews\\ProviderInterface');
    }

    /**
     * Mocks a response instance of ResponseInterface.
     *
     * @param  $responseBody
     * @return Mockery\LegacyMockInterface|Mockery\MockInterface|ResponseInterface
     */
    public function getMockedResponse($responseBody)
    {
        $mockedResponse = \Mockery::mock(ResponseInterface::class);
        $mockedStream = \Mockery::mock(StreamInterface::class);

        $mockedStream
            ->shouldReceive('getContents')
            ->andReturn($responseBody)
            ->once();

        $mockedResponse
            ->shouldReceive('getBody')
            ->andReturn($mockedStream)
            ->once();

        return $mockedResponse;
    }

    /**
     * Mocks a abstract Api client.
     *
     * @param  null $httpClient
     * @return Mockery\LegacyMockInterface|Mockery\MockInterface|AbstractApiClient
     */
    public function getMockedApiClient($httpClient = null)
    {
        if (!$httpClient) {
            $httpClient = Mockery::mock(\GuzzleHttp\ClientInterface::class);
        }
        return Mockery::mock(AbstractApiClient::class, [$httpClient])->makePartial();
    }

    /**
     * Creates a mocked abstract base request.
     *
     * @param AbstractApiClient $client
     * @param array             $options
     * @param array             $requiredFields
     *
     * @return Mockery\Mock
     */
    public function getMockedAbstractBaseRequest(
        AbstractApiClient  $client,
        array $options = [],
        array $requiredFields = []
    ) {
        $mock = Mockery::mock(AbstractBaseRequest::class, array($options, $client))
            ->makePartial();

        $mock->shouldReceive('requiredFields')
            ->withNoArgs()
            ->andReturn($requiredFields);

        return $mock;
    }
}
