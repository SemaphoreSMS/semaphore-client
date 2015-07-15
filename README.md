# Semaphore Client

Semaphore Client is a PHP wrapper for the Semaphore SMS API'

# Table of Contents
 - [Installation](#installation)
 - [Basic Usage](#basic-usage)
 - [License](#license)

## Installation

```sh
composer require kickstart/semaphore-client
```

## Basic Usage
```php
<?php
    require_once( 'vendor/autoload.php' );

    use Semaphore\SemaphoreClient;
    $client = new SemaphoreClient( '<YOUR_API_KEY>', '<OPTIONAL_SENDER_ID' );
    $client->send( '09991234567', 'Your message' );

```