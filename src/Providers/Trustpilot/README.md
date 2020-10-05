# Trustpilot
[API Specification](https://documentation-apidocumentation.trustpilot.com/)


## Usage

#### Create a trustpilot client
```
$manager = new \PodPoint\Reviews\Manager();
$trustpilot = $manager->withProvider('trustpilot', [])
```

#### Send a service invite

```
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

Required Fields:
* consumerEmail
* consumerName
* referenceNumber

#### Get service reviews

```
$trustpilot->service()->fetchAll([
 'startDateTime' => '2013-09-07T13:37:00',
 'endDateTime' => '2013-09-20T13:37:00',
]);
```

See all supported query parameters and response:
[Api docs](https://documentation-apidocumentation.trustpilot.com/business-units-api#business-unit-private-reviews)

#### Find service review

```
$trustpilot->service()->find($reviewId);
```
