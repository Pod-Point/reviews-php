<?php

namespace PodPoint\Reviews\Cache;

use PodPoint\Reviews\Exceptions\InvalidTtlResponseFieldUnitException;
use PodPoint\Reviews\Request\AbstractCacheableRequest;
use PodPoint\Reviews\TimeUnitConverter;

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
     * Unit of the ttl response field. Can be in seconds, minutes, hours.
     *
     * @var string
     */
    protected $cacheTtlResponseFieldUnit = 'seconds';

    /**
     * The cache expected time unit for cache driver.
     *
     * @var string
     */
    protected $cacheAdapterTtlUnit = 'minutes';

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
     * @throws InvalidTtlResponseFieldUnitException
     * @throws \PodPoint\Reviews\Exceptions\InvalidTimeUnitException
     */
    public function convertTtlResponseField(int $ttl): int
    {
        if (is_null($this->cacheTtlResponseFieldUnit)) {
            throw new InvalidTtlResponseFieldUnitException();
        }

        if ($this->cacheTtlResponseFieldUnit === $this->cacheAdapterTtlUnit) {
            return $ttl;
        }

        return (new TimeUnitConverter())
            ->convert(
                $ttl,
                $this->cacheTtlResponseFieldUnit,
                $this->cacheAdapterTtlUnit
            );
    }
}
