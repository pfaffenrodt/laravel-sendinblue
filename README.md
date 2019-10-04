# Sendinblue for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/damcclean/laravel-sendinblue.svg?style=flat-square)](https://packagist.org/packages/damcclean/laravel-sendinblue)
[![Build Status](https://img.shields.io/travis/damcclean/laravel-sendinblue/master.svg?style=flat-square)](https://travis-ci.org/damcclean/laravel-sendinblue)
[![Total Downloads](https://img.shields.io/packagist/dt/damcclean/laravel-sendinblue.svg?style=flat-square)](https://packagist.org/packages/damcclean/laravel-sendinblue)

This package provides an easy wrapper around the Sendinblue API for Laravel applications. Behind the scenes of this package, we use the [official Sendinblue SDK](https://github.com/sendinblue/APIv3-php-library/tree/master/docs/Api) for PHP.

This package is **not a mail driver**, just a manager for contacts and other Sendinblue things. Think of it like the Sendinblue version of [Spatie's Newsletter](https://github.com/spatie/laravel-newsletter) package. This package is in no way affiliated with Sendinblue.

Here are some of the available methods:

```php
...
use Sendinblue;
...

// Create a contact, with just an email
Sendinblue::createContact('bob@example.com');

// Create a contact, with more information
Sendinblue::createContact('billy@example.com', [
    'FNAME' => 'Billy',
    'LNAME' => 'Smith'
]);

// Delete a contact
Sendinblue::deleteContact('jen@example.com');

// Create a folder
Sendinblue::createFolder('Personal');

// Create a list
// First param is the name, second is the id of the folder
Sendinblue::createList('Blog Mailing List', 7);
```

## Installation

You can install the package via composer:

```bash
composer require damcclean/laravel-sendinblue
```

Then you can publish the configuration file:

```bash
php artisan vendor:publish --provider="Damcclean\Sendinblue\SendinblueServiceProvider"
```

## Usage

After you've installed the package and published the config file, you'll need to add your Sendinblue API Key to your `.env` file:

```bash
SENDINBLUE_APIKEY=...
```

Then you can simply use the Sendinblue stuff, like this:

``` php
use Sendinblue;

Sendinblue::createContact('bob@example.com');
```

### Testing

``` bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email duncan@mcclean.co.uk instead of using the issue tracker.

## Credits

- [Duncan McClean](https://github.com/damcclean)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
