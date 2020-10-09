<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Review provider configurations
    |--------------------------------------------------------------------------
    */
    'reviews_io' => [
        'store' => env('REVIEWS_CO_UK_STORE'),
        'api_key' => env('REVIEWS_CO_UK_API_KEY'),
        'api_base_host' => env('REVIEWS_CO_UK_API_BASE_HOST'),
    ],
    
    'trustpilot' => [
        'username' => env('TRUSTPILOT_USERNAME'),
        'password' => env('TRUSTPILOT_PASSWORD'),
        'client_secret' => env('TRUSTPILOT_SECRET_KEY'),
        'client_id' => env('TRUSTPILOT_CLIENT_ID'),
        'business_unit_id' => env('TRUSTPILOT_BUSINESS_ID'),
        'api_base_host' => env('TRUSTPILOT_API_BASE_HOST'),
        'api_invitation_host' => env('TRUSTPILOT_API_INVITATION_HOST'),
    ],
];
