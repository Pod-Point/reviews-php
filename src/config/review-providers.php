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
    ],
    
    'trustpilot' => [
        'username' => env('TRUSTPILOT_USERNAME'),
        'password' => env('TRUSTPILOT_PASSWORD'),
        'client_secret' => env('TRUSTPILOT_SECRET_KEY'),
        'client_id' => env('TRUSTPILOT_CLIENT_ID'),
        'business_unit_id' => env('TRUSTPILOT_BUSINESS_ID'),
        'invite_reply_to_email' => env('TRUSTPILOT_INVITE_REPLY_TO_EMAIL'),
        'invite_redirect_uri' => env('TRUSTPILOT_INVITE_REDIRECT_URI')
    ],
];
