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
     * @return string
     */
    public function getCacheTtlResponseField(): string
    {
        return $this->cacheTtlResponseField;
    }

    /**
     * @param string $cacheTtlResponseField
     */
    public function setCacheTtlResponseField(string $cacheTtlResponseField): void
    {
        $this->cacheTtlResponseField = $cacheTtlResponseField;
    }

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

            return $this->convertFromSecondsToMinutes($ttl);
        }

        return $default;
    }

    /**
     * Converts from seconds to minutes.
     *
     * @param $value
     * @return int
     */
    protected function convertFromSecondsToMinutes(int $value): int
    {
        if ($value <= 0) {
            return 0;
        }

        return (int) $value / 60;
    }
}
