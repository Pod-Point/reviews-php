<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Review provider Configurations
    |--------------------------------------------------------------------------
    */

    'reviews_co_uk' => [
        'url'       => env('REVIEWS_CO_UK_URL', 'https://api.reviews.co.uk'),
        'store'     => env('REVIEWS_CO_UK_STORE'),
        'api_key'   => env('REVIEWS_CO_UK_API_KEY'),
    ],
];
