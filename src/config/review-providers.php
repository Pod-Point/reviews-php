<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Review provider configurations
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'reviewsio' => [
            'url' => env('REVIEWS_CO_UK_URL', 'https://api.reviews.co.uk'),
            'store' => env('REVIEWS_CO_UK_STORE'),
            'api_key' => env('REVIEWS_CO_UK_API_KEY'),
        ],
        'trustpilot' => [
            'username' => env('TRUSTPILOT_USERNAME'),
            'password' => env('TRUSTPILOT_PASSWORD'),
            'secret_key' => env('TRUSTPILOT_SECRET_KEY'),
            'api_key' => env('TRUSTPILOT_API_KEY'),
            'business_id' => env('TRUSTPILOT_BUSINESS_ID'),
        ],
    ],
];
