<?php

namespace PodPoint\Reviews\Tests;

use Mockery;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $provider
     */
    public function mockReviewProviderFactory(string $provider): void
    {
        Mockery::mock('alias:PodPoint\\Reviews\\Providers\\' . $provider . '\\Factory', 'PodPoint\\Reviews\\ReviewsServiceInterface');
    }

    /**
     * @param $body
     * @return Mockery\Expectation|Mockery\ExpectationInterface|Mockery\HigherOrderMessage
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
}
