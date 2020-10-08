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
* `Service`: it can be company/business/merchant/service review.
* `Product`: a product review, meaning it has a clear link to a product.

## Installation

 1. Add the following in the repository section of the composer.json
```json
{  
    "type": "git",  
    "url": "git@github.com:pod-point/reviews-php.git"  
}
```
2. Run the following command inside of the the desired project workspace.
```bash
composer require pod-point/reviews-php
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
        'trustpilot' => [
            'username' => '',
            'password' => '',
            'api_secret' => '',
            'api_key' => '',
            'business_unit_id' => '',
        ],
];
```

All the providers should respect the same interface. 

```php
$reviews = new \PodPoint\Reviews\Reviews($config);
$trustpilot = $reviews->trustpilot();
```
Laravel Example:
```php
$trustpilot = Reviews::trustpilot()
```

Here is a example of the provided interface that is shared across the supported review providers.
```php
$trustpilot->service()->invite((array) $serviceInviteOptions);
$trustpilot->service()->findReview((string) $reviewId);
$trustpilot->service()->getReviews((array) $serviceReviewsFilterOptions);
```

For more details about each provider options see:
 * [Trustpilot](https://github.com/Pod-Point/reviews-php/Providers/Trustpilot/README.md) 

## Semantic versioning
Reviews PHP follows [semantic versioning](https://semver.org/) specifications.

## License
The MIT License (MIT). Please see [License File](https://github.com/Pod-Point/reviews-php/LICENCE) for more information.

## Development
### Testing

This project uses PHPUnit, run the following command to run the tests:
```bash
vendor/bin/phpunit
```
