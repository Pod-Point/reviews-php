<?php

namespace PodPoint\Reviews\Tests;

use Mockery;
use PodPoint\Reviews\AbstractApiClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Mocks a review provider class.
     *
     * @param string $provider
     */
    public function mockReviewProviderProvider(string $provider): void
    {
        Mockery::mock('alias:PodPoint\\Reviews\\Providers\\' . $provider . '\\Provider', 'PodPoint\\Reviews\\ProviderInterface');
    }

    /**
     * Mocks a response instance of ResponseInterface.
     *
     * @param $responseBody
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
     * @return Mockery\LegacyMockInterface|Mockery\MockInterface|AbstractApiClient
     */
    public function getMockedApiClient()
    {
        return Mockery::mock(AbstractApiClient::class)->makePartial();
    }
}
