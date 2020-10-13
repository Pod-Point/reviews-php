<?php

namespace PodPoint\Reviews\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Reviews.
 */
class Reviews extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'reviews';
    }
}
