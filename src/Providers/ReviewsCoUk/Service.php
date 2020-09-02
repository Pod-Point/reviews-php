<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

use GuzzleHttp\Client;
use PodPoint\Reviews\Service as ServiceInterface;
use Psr\Http\Message\ResponseInterface;

class Service implements ServiceInterface
{
    /**
     * A HTTP client instance.
     *
     * @var Client
     */
    private Client $client;

    /**
     * A reviews.co.uk configuration instance.
     *
     * @var Configuration
     */
    private Configuration $config;

    /**
     * Sets the client and configuration for the service.
     *
     * @param Client $client
     * @param Configuration $config
     */
    public function __construct(Client $client, Configuration $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Creates an invite.
     *
     * @param array $options
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function invite(array $options)
    {
        $options = new InviteOptions($options);

        $this->request('POST', 'merchant/invitation', [
            'form_params' => [
                'name' => $options->name,
                'email' => $options->email,
                'order_number' => $options->orderNumber,
            ],
        ]);
    }

    /**
     * Get review(s).
     *
     * @param array $options
     *
     * @return array|null
     */
    public function get(array $options)
    {
        $options = new GetOptions($options);

        $parameters = [
            'store' => $this->config->store,
        ];

        if ($options->hasOrderNumber()) {
            $parameters['apikey'] = $this->config->apiKey;
            $parameters['order_number'] = $options->orderNumber;
        } else {
            $parameters['min_date'] = $options->minDate;
            $parameters['max_date'] = $options->maxDate;
        }

        $response = $this->request('GET', 'merchant/reviews', [
            'query' => $parameters,
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Makes a request using the common options.
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(string $method, string $uri = '', array $options = [])
    {
        return $this->client->request($method, $uri, array_merge([
            'base_uri' => $this->config->url,
            'headers' => [
                'store' => $this->config->store,
                'apikey' => $this->config->apiKey,
            ],
        ], $options));
    }
}
