<?php


namespace PodPoint\Reviews\Facade;

use Illuminate\Support\Facades\Facade;

class Reviews extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reviews';
    }
}
