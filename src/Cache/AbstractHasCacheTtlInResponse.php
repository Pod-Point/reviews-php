<?php


namespace PodPoint\Reviews\Cache;

use PodPoint\Reviews\Request\AbstractCacheableRequest;

abstract class AbstractHasCacheTtlInResponse extends AbstractCacheableRequest
{
    /**
     * The name of the field which has expires or ttl.
     * @var
     */
    protected $cacheTtlResponseField;

    /**
     * @param array|null $responseBody
     * @param int|null $default
     * @return int
     */
    public function getCacheableTtlFromResponse(array $responseBody, int $default = null): int
    {
        if ($this->cacheTtlResponseField && isset($responseBody[$this->cacheTtlResponseField])) {
            return (int) $responseBody[$this->cacheTtlResponseField];
        }

        return $default;
    }
}
