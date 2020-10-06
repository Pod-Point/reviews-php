# ReviewsIO
[API Specification](https://api.reviews.io/documentation)

## Usage

#### Create a ReviewsIO client
Any PHP Application
```
$manager = new \PodPoint\Reviews\Manager();
$reviewsIo = $manager->withProvider('reviewsIO')
```
Laravel:
```php
$reviewsIo = Reviews::reviewsIO()
```

#### Send a service invite
Required Fields:
* name
* order_id
* email

```php
$reviewsIo->service()->invite([
     'store': 'my-company',
     'apikey': '######APIKEY######',
     'name': 'Mr David Jones',
     'email': 'david-jones@example.com',
     'order_id': '12345',
     'template_id': '934',
]);

```
See all the supported parameters
[Api Docs](https://api.reviews.io/documentation/#api-Queue_Email_Invitations-Queue_Merchant_Review_Invite) 

#### Get service reviews

```php
$reviewsIo->service()->getReviews([
 'min_date' => '2013-09-07',
 'max_date' => '2013-09-20',
]);
```
See all supported query parameters and responses:
[Api docs](https://api.reviews.io/documentation/#api-Merchant_Reviews-List_All_Merchant_Reviews)

#### Find service review
```php
$reviewsIo->service()->findReview($reviewId);
```
See response example:
[Api docs](https://api.reviews.io/documentation/#api-Merchant_Reviews-Get_Latest_Merchant_Reviews)