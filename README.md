# [Error Tracker](https://error-tracker.com) PHP SDK

The core Error Tracker SDK for [PHP](https://php.net). This library is for
interacting with the Error Tracker API with PHP. You can also use this package
for registering a error handler for a vanilla PHP app.

## Installation

You can install this package with composer.

```php
composer require erorr-traker/php-sdk
```

## The API Client

The API client class can be used to access to the Error Tracker API

### Initialization

```php
use ErrorTracker\Client;

$client = new Client('APP_KEY');
```

### Reporting an error

```php
$client->report([
    'name' => 'The error name'm
    'text' => 'A message about the error'
]);
```


## The Error Handler

If you are using a vanilla PHP application you can register a error handler to
catch your errors and sent them straight to Error Tracker. All you need to do
is create a new instance of the `Handler` class.

```php
use ErrorTracker\Handler;

new Handler('MY_APP_KEY');
```

You can disable and enable sending errors with the `enabled` property of the
`Handler` class

```php
$handler = new Handler('MY_APP_KEY');

// Turn off
$handler->enabled = false;

// Turn back on
$handler->enabled = true;
```

You can unregister the handlers with the `unregister` function

```php
$handler->unregister();
```

## Contributing

### Getting set up

Getting getup is quite simple you can clone the repo and run `composer install`.
Once you have done this you can start hacking.

### Testing

All new features of bug fixes must be tested. Testing is with phpunit and can
be run with the following command

~~~ bash
composer run-script test
~~~

### Coding Standards

This library uses psr2 coding standards and `squizlabs/php_codesniffer` for
linting. There is a composer script setup for linting.

~~~ bash
composer run-script lint
~~~

### Pull Requests

Before you create a pull request with you changes, the pre-commit script must
pass. That can be run as follows.

~~~ bash
composer run-script pre-commit
~~~

## Credits

This package is created and maintained by [Practically.io](https://practically.io/)

