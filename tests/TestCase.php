<?php

namespace PodPoint\Reviews\Tests;

use Mockery;
use PodPoint\Reviews\AbstractApiClient;
use PodPoint\Reviews\Request\BaseRequest;
use PodPoint\Reviews\Tests\Mocks\MockedApiClient;
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
    public function getMockedBaseRequest(AbstractApiClient  $client, array $options = [], $requiredFields = [])
    {
        $mock = Mockery::mock(BaseRequest::class, array($client, $options))
            ->makePartial();


        $mock->shouldReceive('getRequiredFields')
            ->withNoArgs()
            ->andReturn($requiredFields);

        $mock->shouldReceive('validate')
            ->withNoArgs()
            ->andReturn(true);

        return $mock;
    }
}
