<?php

namespace PodPoint\Reviews\Cache;

use PodPoint\Reviews\Request\AbstractCacheableRequest;

/**
 * Class AbstractHasCacheTtlInResponse
 */
abstract class AbstractHasCacheTtlInResponse extends AbstractCacheableRequest
{
    /**
     * The name of the field which has expires or ttl.
     *
     * @var string
     */
    protected $cacheTtlResponseField;

    /**
     * Returns the ttl from the body of the response.
     *
     * @param array|null $responseBody
     * @param int|null $default
     *
     * @return int
     */
    public function getCacheableTtlFromResponse(array $responseBody, int $default = null): int
    {
        if ($this->cacheTtlResponseField && isset($responseBody[$this->cacheTtlResponseField])) {
            $ttlInSeconds = (int) $responseBody[$this->cacheTtlResponseField];

            return $ttlInSeconds/60;
        }

        return $default;
    }
}
