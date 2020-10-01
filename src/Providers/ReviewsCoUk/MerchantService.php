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
     * A The Store Id.
     *
     * @var string
     */
    private $store;

    /**
     * @var Config
     */
    private $config;

    /**
     * Sets the client and configuration for the service.
     *
     * @param  Client $client
     * @param  Config $config
     */
    public function __construct(Client $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
        $this->store = $this->config->get('review-providers.providers.reviews_co_uk.store');
    }

    /**
     * Creates a merchant invite.
     *
     * @inheritdoc
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendOrderReviewInvite(string $name, string $email, string $orderNumber): void
    {
        $this->request('POST', 'merchant/invitation', [
            'form_params' => [
                'name' => $name,
                'email' => $email,
                'order_id' => $orderNumber,
            ],
        ]);
    }

    /**
     * Get merchant review(s).
     *
     * @inheritdoc
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrderReview(string $orderNumber): ?array
    {
        $response = $this->request('GET', 'merchant/reviews', [
            'query' => [
                'order_id' => $orderNumber,
                'store' => $this->store,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get merchant review(s) between dates.
     *
     * @inheritdoc
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCompanyReviewsBetweenDates(string $from = null, string $to = null): ?array
    {
        $parameters = [
            'store' => $this->store,
        ];

        if ($from) {
            $parameters['min_date'] = $from;
        }

        if ($to) {
            $parameters['max_date'] = $to;
        }

        $response = $this->request('GET', 'merchant/reviews', [
            'query' => $parameters,
        ]);

        return json_decode($response->getBody()->getContents(), true);
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
            'base_uri' => $this->config->get('review-providers.providers.reviews_co_uk.url'),
            'headers' => [
                'store' => $this->config->get('review-providers.providers.reviews_co_uk.store'),
                'apikey' => $this->config->get('review-providers.providers.reviews_co_uk.api_key'),
            ],
        ], $options));
    }
}
