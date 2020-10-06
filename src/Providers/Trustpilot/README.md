# Trustpilot
[API Specification](https://documentation-apidocumentation.trustpilot.com/)

## Usage

#### Create a trustpilot client
Any PHP Application
```
$manager = new \PodPoint\Reviews\Manager();
$trustpilot = $manager->withProvider('trustpilot')
```
Laravel:
```php
$trustpilot = Reviews::trustpilot()
```

#### Send a service invite
Required Fields:
* consumerEmail
* consumerName
* referenceNumber

```php
$trustpilot->service()->invite([
    'consumerEmail' => 'john.doe@trustpilot.com', 
    'consumerName'=> 'John Doe',
    'replyTo' => 'john.doe@trustpilot.com',
    'referenceNumber' => 'inv00001',
    'locale" => "en-US',
    'senderEmail" => 'john.doe@trustpilot.com',
    'serviceReviewInvitation" =>  {
        'preferredSendTime" => '2013-09-07T13:37:00',
        'redirectUri" => "http://trustpilot.com',
        'tags'=>  [
          'tag1',
          'tag2'
        ],
        'templateId' => '507f191e810c19729de860ea'
      },
     'locationId' =>  'ABC123',
     'senderName' =>  'John Doe'
]);
```
#### Get service reviews

```php
$trustpilot->service()->getReviews([
 'startDateTime' => '2013-09-07T13:37:00',
 'endDateTime' => '2013-09-20T13:37:00',
]);
```
See all supported query parameters and responses:
[Api docs](https://documentation-apidocumentation.trustpilot.com/business-units-api#business-unit-private-reviews)

#### Find service review
```php
$trustpilot->service()->findReview($reviewId);
```
See response example:
[Api docs](https://documentation-apidocumentation.trustpilot.com/service-reviews-api#get-private-review)
