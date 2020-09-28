<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Review provider configurations
    |--------------------------------------------------------------------------
    */

    'default' => 'reviews_co_uk',

    'providers' => [
        'reviews_co_uk' => [
            'url' => env('REVIEWS_CO_UK_URL', 'https://api.reviews.co.uk'),
            'store' => env('REVIEWS_CO_UK_STORE'),
            'api_key' => env('REVIEWS_CO_UK_API_KEY'),
        ],
        'trustpilot' => [
            'businessUnitId' => null,
            'locale' => 'en-GB',
            'invites' => [
                'redirectUri' => null,
                'replyTo' => null,
                'senderEmail' => null,
                'senderName' => null,
                'templateId' => null,
            ],
            'auth' => [
                'username' => env('TRUSTPILOT_USERNAME'),
                'password' => env('TRUSTPILOT_PASSWORD'),
                'secretKey' => env('TRUSTPILOT_SECRET_KEY'),
                'apiKey' => env('TRUSTPILOT_API_KEY'),
            ],
        ],
    ],
];
