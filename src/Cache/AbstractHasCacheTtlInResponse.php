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
     * @param array $responseBody
     * @param int|null $default
     *
     * @return int
     */
    public function getCacheableTtlFromResponse(array $responseBody, int $default = null): int
    {
        if ($this->cacheTtlResponseField && isset($responseBody[$this->cacheTtlResponseField])) {
            $ttl = (int) $responseBody[$this->cacheTtlResponseField];

            return $this->convertTtlResponseField($ttl);
        }

        return $default;
    }

    /**
     * Converts the TTL response field from time unit.
     *
     * @param int $ttl
     *
     * @return int
     */
    public function convertTtlResponseField(int $ttl): int
    {
        return self::convertFromSecondsToMinutes($ttl);
    }

    /**
     * Converts from seconds to minutes.
     *
     * @param $value
     * @return int
     */
    public static function convertFromSecondsToMinutes(int $value): int
    {
        if ($value <= 0) {
            return 0;
        }

        return (int) $value / 60;
    }
}
