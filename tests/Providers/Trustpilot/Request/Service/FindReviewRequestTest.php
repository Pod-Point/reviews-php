<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot\Request\Service;

use PodPoint\Reviews\Providers\Trustpilot\Request\Service\FindReviewRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\GetReviewsRequest;
use PodPoint\Reviews\Tests\TestCase;

class FindReviewRequestTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $options = ['reviewId' => 'review-id-123'];
        $mockedApiClient = $this->getMockedApiClient();
        $request = new FindReviewRequest($mockedApiClient, $options);

        $this->assertEquals($mockedApiClient, $request->getHttpClient());
        $this->assertEquals($options, $request->getOptions());
    }

    /**
     *
     */
    public function testRequiredFields()
    {
        $mockedApiClient = $this->getMockedApiClient();
        $request = new FindReviewRequest($mockedApiClient, ['reviewId' => 'review-id-123']);

        $this->assertEquals(['reviewId'], $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     */
    public function testGetRequest()
    {
        $options = [
            'reviewId' => 'review-id-123',
            'businessUnitId' => 'business-123',
        ];

        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new FindReviewRequest($mockedApiClient, $options);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.trustpilot.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/private/reviews/review-id-123', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     */
    public function testSend()
    {
        $options = ['reviewId' => 'review-id-123', 'businessUnitId' => 'business-123'];

        $response = $this->getMockedResponse('{"status": "OK", "message": "successful"}');
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new FindReviewRequest($mockedApiClient, $options);

        $this->assertEquals([
            'status' => 'OK',
            'message' => 'successful',
        ], $request->send());
    }
}
