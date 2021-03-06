# Reviews

[![Build Status](https://travis-ci.com/Pod-Point/reviews-php.svg?branch=master)](https://travis-ci.com/Pod-Point/reviews-php)
[![codecov](https://codecov.io/gh/Pod-Point/reviews-php/branch/master/graph/badge.svg)](https://codecov.io/gh/Pod-Point/reviews-php)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)

A reviews service manager for PHP applications. This package provides a shared interface to use different reviews providers.
List of supported reviews providers:
 * [Trustpilot](https://trustpilot.com)
 * [ReviewsIO](https://reviews.co.uk/)

## Glossary

A review is an evaluation of a publication, product, or company for example. In this package we have a clear differentiation of types of reviews that can be for:
* `Merchant`: it can be company/business/merchant/service review.
* `Product`: a product review, meaning it has a clear link to a product.

## Installation

 1. Add the following in the repository section of the composer.json
```json
{
    "type": "git",
    "url": "git@github.com:pod-point/reviews-php.git"
}
```
2. Run the following command inside of the desired project workspace.
```bash
composer require pod-point/reviews-php
```

##### Publish the configuration - Laravel
1. Add the provider to the list of providers on config/app.php
```php
PodPoint\Reviews\LaravelServiceProvider::class

```

2.
```php
php artisan vendor:publish
```

## Usage
The Reviews class takes an array as the first parameter, see example of config file below:
```php
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
```

The Trustpilot requires the access token to be cached, in order to ensure you do it when consuming this package ensure you need to set the cache driver.

Example:
```php
$cacheAdapter = new \PodPoint\Reviews\Cache\LaravelCacheAdapter();
\PodPoint\Reviews\Cache\CacheProvider::setInstance($cacheAdapter);
```

All the providers should respect the same interface.

```php
$reviews = new \PodPoint\Reviews\Reviews($config);
$trustpilot = $reviews->trustpilot();
```
Laravel Example:
```php
$trustpilot = Reviews::trustpilot();
```

Here is an example of the provided interface that is shared across the supported review providers.
```php
$trustpilot->merchant()->invite((array) $serviceInviteOptions);
$trustpilot->merchant()->findReview((string) $reviewId);
$trustpilot->merchant()->getReviews((array) $serviceReviewsFilterOptions);
```

The ``PodPoint\Reviews\Providers\Trustpilot\Request\AccessTokenRequest`` requires Cache Adapter/Driver. If you are getting CacheAdapterException you must set a cache driver.

Example:
```
CacheProvider::setInstance(new LaravelCacheAdapter());
```  

## Compatibility table
This package is compatible up to Laravel 7. If used with higher versions of Laravel, the guzzle package needs to be upgraded.  

| Laravel Version | Package Version |
| ------------- | ------------- |
| ^5.2  | 0.1.* |
| ^6.0  | 0.1.* |
| ^7.0  | 0.1.* |

For more details about each provider request options see:
 * [Trustpilot](https://github.com/Pod-Point/reviews-php/blob/master/src/Providers/Trustpilot/README.md) 
 * [ReviewsIO](https://github.com/Pod-Point/reviews-php/blob/master/src/Providers/ReviewsIo/README.md) 

## Semantic versioning
Reviews PHP follows [semantic versioning](https://semver.org/) specifications.

## License
The MIT License (MIT). Please see [License File](https://github.com/Pod-Point/reviews-php/LICENCE) for more information.

## Development

### Caching

To cache Request's response, you must extend the Request class using the **AbstractCacheableRequest** class, this will automatically cache the response. The **AbstractCacheableRequest** has two optional parameters ``$cacheTtl`` and ``$cacheKey``, these can be overridden in demanded request. If no ``$cacheKey`` is set the ``getCacheableKey`` is used to set the cache key and it will hash the class name using sha1 to have unique cacheKey. 

If the Request class requires customisation for send method, make sure to call the ``parent::send();`` method which does the cache calls. 

If the cache TTL is in the response of the api request instead of using **AbstractCacheableRequest** use the **AbstractHasCacheTtlInResponse** class. The **AbstractHasCacheTtlInResponse** has ``$cacheTtlResponseField`` which defines the key holds the cache TTL in the response and will be used when setting cache. 

#### CacheProvider

The CacheProvider is a singleton a special class, provides the adapters to be initialized within the ``AbstractCacheableRequest::__construct``.  

#### Adding new Cache Adapters
The ``PodPoint\Reviews\Cache\CacheProvider`` acts a Cache Adapter/Driver provider, the cache adapter can be replaced using ``CacheProvider::setInstance`` or the ``CacheProvider::getInstance`` can be updated to return Cache Adapter/Driver.

#### Laravel Caching

By default, the ``PodPoint\Reviews\LaravelServiceProvider`` registers the LaravelCacheAdapter as an instance, if needs to be overridden a new extended ServiceProvider can be created to override the protected setCacheAdapter method. 

### Testing

This project uses PHPUnit, run the following command to run the tests:
```bash
vendor/bin/phpunit
```
