<?php

namespace PodPoint\Reviews\Tests;

use GuzzleHttp\Psr7\Request;
use Mockery;
use PodPoint\Reviews\AbstractApiClient;
use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Request\BaseRequest;
use PodPoint\Reviews\Tests\Mocks\MockedApiClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $provider
     */
    public function mockReviewProviderProvider(string $provider): void
    {
        Mockery::mock('alias:PodPoint\\Reviews\\Providers\\' . $provider . '\\Provider', 'PodPoint\\Reviews\\ProviderInterface');
    }

    /**
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
     * @return Mockery\LegacyMockInterface|Mockery\MockInterface|AbstractApiClient
     */
    public function getMockedApiClient()
    {
        return Mockery::mock(AbstractApiClient::class)->makePartial();
    }

    /**
     * @param AbstractApiClient $client
     * @param array $options
     * @param array $requiredFields
     * @return Mockery\Mock
     */
    public function getMockedBaseRequest(ApiClientInterface $client, array $options = [], $requiredFields = [])
    {
        $mock = Mockery::mock(BaseRequest::class, array($client, $options))
            ->makePartial();

        $mock->shouldReceive('requiredFields')
            ->withNoArgs()
            ->andReturn($requiredFields);

        return $mock;
    }
}
