

#  Reviews-php
[![Build Status](https://travis-ci.com/Pod-Point/reviews-php.svg?branch=master)](https://travis-ci.com/Pod-Point/reviews-php) [![codecov](https://codecov.io/gh/Pod-Point/reviews-php/branch/master/graph/badge.svg)](https://codecov.io/gh/Pod-Point/reviews-php)

A review package for our PHP applications. Currently only includes reviews.co.uk but there are plans to add Trustpilot.

##  Installation

Follow the steps below in the desired project where you would like to install this package

 1. Add the following in the repository section of the composer.json .
```json
{  
    "type": "git",  
    "url": "git@github.com:pod-point/reviews-php.git"  
}
```
```
2. Run the following command.
```bash
php artisan vendor:publish --provider="PodPoint\Reviews\Providers\ReviewsProvider"
```
3. Finally we need to update the .env to let the new package know the details of the review provider. The following are required.
 ```env
REVIEWS_CO_UK_STORE=
REVIEWS_CO_UK_API_KEY=
```
If for any reason you need to change the url for reviews.co.uk the following is optional. The default is https://api.reviews.co.uk
 ```env
REVIEWS_CO_UK_URL=
```
##  Development

#### Setup

 1. First we will need to clone this package to your machine.  
```bash
git clone git@github.com:Pod-Point/reviews-php.git
```
2. Copy the .env.example to .env and head to the docker image document we have [here](https://podpoint.atlassian.net/wiki/spaces/SKB/pages/2086305838/Base+images+for+docker+containers) and copy the reviews-php base container image to the ECS_IMAGE_URL value inside of the .env
```bash
cp .env.example .env
```
4. Next we need to build the docker container.
```bash
make start
```
5. And finally we need to run composer install
```bash
make run composer install
```
Now we are all good to start developing and testing the package.

####  Testing

This package uses phpunit. To run the test suites for this project run the following command.  Notice that in this command we add '--' in between the make and test words. This tells Make to ignore any of the options with '--' such as '--stop-on-error' 
```bash
make -- test
```
if you wanted to run the tests with the filter option. It would be the following:
```bash
make -- test --filter SomeTests
```
