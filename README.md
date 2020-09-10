
#  Reviews-php
[![Build Status](https://travis-ci.com/Pod-Point/reviews-php.svg?branch=master)](https://travis-ci.com/Pod-Point/reviews-php) [![codecov](https://codecov.io/gh/Pod-Point/reviews-php/branch/master/graph/badge.svg)](https://codecov.io/gh/Pod-Point/reviews-php)

A review package for our PHP applications. Currently only includes reviews.co.uk but there are plans to add Trustpilot.

##  Installation

Run the following in the desired project where you would like to install this package
```bash
composer require pod-point/reviews-php
```
##  Development

#### Setup

 1. First we will need to clone this package to your machine.  
```bash
git clone git@github.com:Pod-Point/reviews-php.git
```
2. Next we need to build the docker container.
```bash
cd reviews-php
make start
```
3. And finally we need to run composer install
```bash
make run composer install
```
Now we are all good to start developing and testing the package.

####  Testing

This package uses PhpUnit. To run the test suites for this project run the following command.  Notice that in this command we add '--' in between the make and test words. This tells Make to ignore any of the options with '--' such as '--stop-on-error' 
```bash
make -- test
```
if you wanted to run the tests with the filter option. It would be the following:
```bash
make -- test --filter SomeTests
```
