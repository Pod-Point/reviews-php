<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

use GuzzleHttp\Client;
use Illuminate\Config\Repository as Config;
use PodPoint\Reviews\Service as ServiceInterface;

class MerchantService implements ServiceInterface
{
    /**
     * A HTTP client instance.
     *
     * @var Client
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * Sets the client and configuration for the service.
     *
     * @param  Client  $client
     * @param  Config  $config
     */
    public function __construct(Client $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Creates a merchant invite.
     *
     * @param  array  $options
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
                'order_id' => $options->orderNumber,
            ],
        ]);
    }

    /**
     * Get merchant review(s).
     *
     * @param array $options
     *
     * @return array|null
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(array $options)
    {
        $options = new GetOptions($options);

        $parameters = [
            'store' => $this->config->get('reviews.reviewsCoUk.store'),
        ];

        if ($options->hasOrderNumber()) {
            $parameters['order_id'] = $options->orderNumber;
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
            'base_uri' => $this->config->get('reviews.reviewsCoUk.url'),
            'headers' => [
                'store' => $this->config->get('reviews.reviewsCoUk.store'),
                'apikey' => $this->config->get('reviews.reviewsCoUk.api_key'),
            ],
        ], $options));
    }
}
