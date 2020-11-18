# ReviewsIO
[API Specification](https://api.reviews.io/documentation)

## Usage

#### Create a ReviewsIO client

The ``\PodPoint\Reviews\Reviews`` class requires, configuration array to be passed in the constructor.

Example config:
```php
$config = [
    'reviews_io' => [
        'store' => env('REVIEWS_CO_UK_STORE'),
        'api_key' => env('REVIEWS_CO_UK_API_KEY'),
    ],
];
```

Any PHP Application
```
$reviews = new \PodPoint\Reviews\Reviews($config);
$reviewsIo = $reviews->withProvider('reviews_io');
```
Laravel:
```php
$reviewsIo = \PodPoint\Reviews\Facade\Reviews::reviews_io();
```

#### Send a service invite
Required Fields:
* name
* order_id
* email

```php
$reviewsIo->merchant()->invite([
    'store' => 'my-company',
    'apikey' => '######APIKEY######',
    'name' => 'Mr David Jones',
    'email' => 'david-jones@example.com',
    'order_id' => '12345',
    'template_id' => '934',
]);

```
See all the supported parameters
[Api Docs](https://api.reviews.io/documentation/#api-Queue_Email_Invitations-Queue_Merchant_Review_Invite)

#### Get service reviews

```php
$reviewsIo->merchant()->getReviews([
    'min_date' => '2013-09-07',
    'max_date' => '2013-09-20',
]);
```
See all supported query parameters and responses:
[Api docs](https://api.reviews.io/documentation/#api-Merchant_Reviews-List_All_Merchant_Reviews)

#### Find service review
```php
$options = [
    'review_id' => <review_id>,
];

// or

$options = [
    'order_number' => <order_number>,
];

$reviewsIo->merchant()->findReview($options);
```
See response example:
[Api docs](https://api.reviews.io/documentation/#api-Merchant_Reviews-Get_Latest_Merchant_Reviews)
