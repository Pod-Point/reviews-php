# Trustpilot
[API Specification](https://documentation-apidocumentation.trustpilot.com/)

## Usage

#### Create a trustpilot client

The ``\PodPoint\Reviews\Reviews`` class requires, configuration array to be passed in the constructor.   

Example config:
```php
$config = [
    'trustpilot' => [
        'username' => env('TRUSTPILOT_USERNAME'),
        'password' => env('TRUSTPILOT_PASSWORD'),
        'client_secret' => env('TRUSTPILOT_SECRET_KEY'),
        'client_id' => env('TRUSTPILOT_CLIENT_ID'),
        'business_unit_id' => env('TRUSTPILOT_BUSINESS_ID'),
    ],
];
```


Any PHP Application
```
$reviews = new \PodPoint\Reviews\Reviews($config);
$trustpilot = $reviews->withProvider('trustpilot')
```

Laravel:
```php
$trustpilot = \PodPoint\Reviews\Facade\Reviews::trustpilot();
```

#### Send a merchant invite
Required Fields:
* consumerEmail
* consumerName
* referenceNumber

```php
$trustpilot->merchant()->invite([
    'consumerEmail' => 'john.doe@trustpilot.com',
    'consumerName' => 'John Doe',
    'replyTo' => 'john.doe@trustpilot.com',
    'referenceNumber' => 'inv00001',
    'locale' => 'en-US',
    'senderEmail' => 'john.doe@trustpilot.com',
    'serviceReviewInvitation' => [
        'preferredSendTime' => '2013-09-07T13:37:00',
        'redirectUri' => "http://trustpilot.com',
        'tags'=>  [
          'tag1',
          'tag2'
        ],
        'templateId' => '507f191e810c19729de860ea'
      ],
     'locationId' =>  'ABC123',
     'senderName' =>  'John Doe'
]);
```
#### Get service reviews

```php
$trustpilot->merchant()->getReviews([
    'startDateTime' => '2013-09-07T13:37:00',
    'endDateTime' => '2013-09-20T13:37:00',
]);
```
See all supported query parameters and responses:
[Api docs](https://documentation-apidocumentation.trustpilot.com/business-units-api#business-unit-private-reviews)

#### Find service review
```php
$trustpilot->merchant()->findReview($reviewId);
```
See response example:
[Api docs](https://documentation-apidocumentation.trustpilot.com/service-reviews-api#get-private-review)
