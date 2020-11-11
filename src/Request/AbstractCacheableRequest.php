<?php

namespace PodPoint\Reviews\Request;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Cache\CacheProvider;

/**
 * Class CacheableRequest
 */
abstract class AbstractCacheableRequest extends AbstractBaseRequest
{
    /**
     * The name of the cacheable request key name.
     *
     * @var string $cacheableKey
     */
    protected $cacheKey;

    /**
     * The cache time to live.
     *
     * @var int
     */
    protected $cacheTtl = 3600;

    /**
     * Instance of cache adapter.
     *
     * @var mixed
     */
    protected $cacheAdapter;

    public function __construct(ApiClientInterface $client, array $options)
    {
        parent::__construct($options, $client);

        $this->cacheAdapter = CacheProvider::getInstance();
    }

    /**
     * Returns the cacheable name of the request.
     *
     * @return string
     */
    public function getCacheableKey(): string
    {
        if ($this->cacheKey) {
            return $this->cacheKey;
        }

        return sha1(get_class($this));
    }

    /**
     * Caches the request, using the default adapter.
     *
     * @return array|mixed
     */
    public function send()
    {
        $cacheKey = $this->getCacheableKey();

        if ($this->cacheAdapter->has($cacheKey)) {
            return $this->cacheAdapter->get($cacheKey);
        }

        $response = $this->apiClient->sendRequest(
            $this->getRequest(),
            $this->withAuthentication
        );

        $response->getStatusCode();

        $responseBody = $this->apiClient->getResponseJson($response);

        $this->cacheAdapter->set($this->getCacheableKey(), $responseBody, $this->cacheTtl);

        return $responseBody;
    }
}
