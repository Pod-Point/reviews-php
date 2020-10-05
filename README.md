# Reviews

[![Build Status](https://travis-ci.com/Pod-Point/reviews-php.svg?branch=master)](https://travis-ci.com/Pod-Point/reviews-php)
[![codecov](https://codecov.io/gh/Pod-Point/reviews-php/branch/master/graph/badge.svg)](https://codecov.io/gh/Pod-Point/reviews-php)

A reviews service manager for PHP applications. This package provides a shared interface to use different reviews providers.
List of supported reviews providers: 
 * [Trustpilot](trustpilot.com) 
 * [ReviewsIO](reviews.co.uk/)

## Glossary

A review is an evaluation of a publication, product, or company for example. In this package we have a clear differentiation of types of reviews that can be for: 
* `Service`: it can be company/business/merchant/service review.
* `Product`: a product review, meaning it has a clear link to a product.

## Installation

To install this package, run the following command:
```bash
composer require pod-point/reviews-php
```

##Usage
All the providers respect the same usage interface. 
Here is a example of the provided interface that is shared across the supported review providers.

```
$manager = new \PodPoint\Reviews\Manager();
$reviewsClient = $manager->withProvider($reviewsClientName, [])

$reviewsClient->product()->invite((array) $productInviteOptions);
$reviewsClient->product()->find((string) $referenceId);
$reviewsClient->product()->fetchAll((array) $productFilterOptions);

$reviewsClient->service()->invite((array) $serviceInviteOptions);
$reviewsClient->service()->find((string) $referenceId);
$reviewsClient->service()->fetchAll((array) $serviceFilterOptions);
```

For more details about each provider options see:
 * [Trustpilot](https://github.com/Pod-Point/reviews-php/Providers/TrustpiloyREADME.md) 

## Development

### Testing

This project uses PHPUnit, run the following command to run the tests:

```bash
vendor/bin/phpunit
```
