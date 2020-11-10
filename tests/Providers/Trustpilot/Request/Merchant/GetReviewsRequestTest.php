<?php

namespace PodPoint\Reviews\Tests\Providers\Trustpilot\Request\Merchant;

use PodPoint\Reviews\Providers\Trustpilot\Request\Merchant\GetReviewsRequest;
use PodPoint\Reviews\Tests\TestCase;

class GetReviewsRequestTest extends TestCase
{
    /**
     * Test construct to make sure properties are set.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testConstruct()
    {
        $options = ['foo' => 'bar'];
        $mockedApiClient = $this->getMockedApiClient();
        $request = new GetReviewsRequest($mockedApiClient, $options);

        $this->assertEquals($mockedApiClient, $request->getApiClient());
        $this->assertEquals($options, $request->getOptions());
    }

    /**
     * Making sure the required fields returns the right required fields.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testRequiredFields()
    {
        $options = ['foo' => 'bar'];
        $mockedApiClient = $this->getMockedApiClient();
        $request = new GetReviewsRequest($mockedApiClient, $options);

        $this->assertEquals([], $request->requiredFields());
    }

    /**
     * Making sure the Request instance is build as expected.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testGetRequest()
    {
        $options = ['foo' => 'bar', 'businessUnitId' => 'business-123'];

        $mockedApiClient = $this->getMockedApiClient();
        $serviceReviewRequest = new GetReviewsRequest($mockedApiClient, $options);

        $request = $serviceReviewRequest->getRequest();

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.trustpilot.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/private/business-units/business-123/reviews', $request->getUri()->getPath());
        $this->assertEquals('foo=bar&businessUnitId=business-123', $request->getUri()->getQuery());
    }

    /**
     * Send should return an array by converting the json response.
     *
     * @throws \PodPoint\Reviews\Exceptions\ValidationException
     */
    public function testSend()
    {
        $options = ['foo' => 'bar', 'businessUnitId' => 'business-123'];

        $responseBody = file_get_contents('tests/stubs/trustpilot/business_unit_private_reviews_response.json');
        $expectedResponse = \GuzzleHttp\json_decode($responseBody, true);

        $response = $this->getMockedResponse($responseBody);
        $mockedApiClient = $this->getMockedApiClient();
        $mockedApiClient->shouldReceive('sendRequest')->withAnyArgs()->andReturn($response);

        $request = new GetReviewsRequest($mockedApiClient, $options);

        $this->assertEquals($expectedResponse, $request->send());
    }
}
