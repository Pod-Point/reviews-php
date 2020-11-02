<?php

namespace PodPoint\Reviews\Request;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Cache\LaravelCacheAdapter;

/**
 * Class CacheableRequest
 *
 * @package PodPoint\Reviews\Request
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
     * @var
     */
    protected $cacheTtl = '3600';

    /**
     * @var
     */
    protected $cacheAdapter;

    public function __construct(ApiClientInterface $client, array $options)
    {
        parent::__construct($client, $options);

        $this->cacheAdapter = new LaravelCacheAdapter();
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

    /*
     * Caches the request, using the default adapter.
     */
    public function send()
    {
        $cacheKey = $this->getCacheableKey();
        if ($this->cacheAdapter->has($cacheKey)) {
            return $this->cacheAdapter->get($cacheKey);
        }

        $response = $this->httpClient->sendRequest(
            $this->getRequest(),
            $this->withAuthentication
        );

        $json = $this->httpClient->getResponseJson($response);

        //TODO: Check if the header response is ok, if not don't cache.
        $this->cacheAdapter->set($this->getCacheableKey(), $json, $this->cacheTtl);

        return $json;
    }
}
