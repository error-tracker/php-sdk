# [Error Tracker](https://error-tracker.com) PHP SDK

The core Error Tracker SDK for [PHP](https://php.net). This library is for
interacting with the Error Tracker API with PHP. You can also use this package
for registering an error handler for a vanilla PHP app.

## Who is this for?

-   Developers who need a universal view of errors and bugs - before their
    client or users complain.
-   Developers who need raw access to the API so you can report your own errors.
-   Those using a native PHP application and need to register an error handler.
-   Developers creating a third party plug-in for an unsupported PHP framework.
-   QA / Testers who need an overall knowledge of errors across multiple systems

## Installation

You can install this package with composer.

```bash
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
    'name' => 'The error name',
    'text' => 'A message about the error'
]);
```

## The Error Handler

If you are using a vanilla PHP application you can register an error handler to
catch your errors and sent them straight to Error Tracker. Simply create a new
instance of the `Handler` class.

```php
use ErrorTracker\Handler;

new Handler('MY_APP_KEY');
```

Disable and enable sending errors with the `enabled` property of the
`Handler` class

```php
$handler = new Handler('MY_APP_KEY');

// Turn off
$handler->enabled = false;

// Turn back on
$handler->enabled = true;
```

Unregister the handlers by using the `unregister` function

```php
$handler->unregister();
```

## Contributing

### Getting set up

Clone the repo and run `composer install`.
Then start hacking!

### Testing

All new features of bug fixes must be tested. Testing is with phpunit and can
be run with the following command

```bash
composer run-script test
```

### Coding Standards

This library uses psr2 coding standards and `squizlabs/php_codesniffer` for
linting. There is a composer script for this:

```bash
composer run-script lint
```

### Pull Requests

Before you create a pull request with you changes, the pre-commit script must
pass. That can be run as follows:

```bash
composer run-script pre-commit
```

## Credits

This package is created and maintained by [Practically.io](https://practically.io/)
