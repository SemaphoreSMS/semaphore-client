# Semaphore Client

Semaphore Client is a PHP wrapper for the Semaphore SMS API

# Table of Contents
 - [Installation](#installation)
 - [Basic Usage](#basic-usage)

## Installation

```sh
composer require kickstartph/semaphore-client
```

## Basic Usage

### Sending Messages
```php
<?php
    require_once( 'vendor/autoload.php' );

    use Semaphore\SemaphoreClient;
    $client = new SemaphoreClient( '{YOUR_API_KEY}', '{OPTIONAL_SENDER_NAME}' ); //Sender Name defaults to SEMAPHORE
    echo $client->send( '09991234567', 'Your message' );
```
The sender ID can be overridden through the client send command as well:
```php
    echo $client->send( '09991234567', 'Your message', '{NEW_SENDER_ID}' );
```

Bulk messages (to up to 1000 numbers ) can also be sent through the same API call by providing a comma delimited set of numbers:

```php
    echo $client->send( '09991234567,09997654321,', 'Your message' );
```

The response will contain a record for each message sent:
```json
[
  {
    "message_id": 1234567,
    "user_id": 99556,
    "user": "user@your.org",
    "account_id": 90290,
    "account": "Your Account Name",
    "recipient": "09991234567",
    "message": "The message you sent",
    "sender_name": "SEMAPHORE",
    "network": "Globe",
    "status": "Queued",
    "type": "Single",
    "source": "Api",
    "created_at": "2016-01-01 00:01:01",
    "updated_at": "2016-01-01 00:01:01"
  }
]
```


### Retrieving Messages
You can retrieve up to 100 sent messages at a time, with support for pagination by passing the optional $page variable:

```php 
    //Will return the results for page 2 of sent messages
    echo $client->messages( [ 'limit'=> 100 , 'page' => 2 ] ); 
```

####Messages by date range:
```php 
    //Use any date format str_to_time() supports
    echo $client->messages( 'startDate' => '2016-10-01, '2016-10-31' );  
```
####Messages by telco network:
```php 
    //Returns all messages sent to recipients on the Globe network
    echo $client->messages( ['globe'] ); 
```

####Supported Filters for retrieving messages
```php
   $options = [
        'limit' => 100,
        'page' => 1,
        'sendername' => 'SEMAPHORE',
        'startDate' => '2016-01-01',
        'endDate' => '2016-02-01',
        'network' => 'globe',
        'status' => 'success'
   ];
```

### Other functions
Below are other calls you can make:
####Account Information
```php
    echo $client->account();
```
```json
{
  "account_id": 12345,
  "account_name": "Your Organization",
  "status": "Active",
  "credit_balance": 5000
}
```
####Users
```php
    echo $account->users();
```
```json
[
  {
    "user_id": 12345,
    "email": "owner@your.org",
    "role": "Owner"
  },
  {
    "user_id": 54321,
    "email": "someguy@your.org",
    "role": "User"
  }
]
```

####Sender Names
```php
    echo $account->sendernames();
```
```json
[
  {
    "name":"Semaphore",
    "status":"Active",
    "created":"2016-01-01 00:00:01"
  },
  {
    "name":"Kickstart",
    "status":"Active",
    "created":"2016-01-01 00:00:01""
  }
]
```
####Transactions
```php
    echo $account->transactions();
```
