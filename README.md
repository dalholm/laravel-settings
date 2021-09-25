# Laravel database settings package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dalholm/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/dalholm/laravel-settings)
[![Total Downloads](https://img.shields.io/packagist/dt/dalholm/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/dalholm/laravel-settings)

Simple and powerful settings package for laravel with fallback and cache option. 

## Installation

You can install the package via composer:

```bash
composer require dalholm/laravel-settings
```

## Publish
```bash
php artisan vendor:publish --tag=laravel-settings
```



## Config
```php
/*
 * You can place your custom package configuration in here.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    | Cache is only working with redis and uses cache tags
    |
    */

    'cache' => [
        'enabled' => env('SETTINGS_CACHE_ENABLED', false),
        'profile' => Dalholm\LaravelSettings\Cache\CacheProfile::class,
        'store' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database settings
    |--------------------------------------------------------------------------
    | You could use what ever you want
    |
    */
    'database' => [
        'connection'    => null,
        'table'         => 'settings',
        'key'           => 'key',
        'value'         => 'value',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    | Use this as a fallback if settings is not yet available in database
    |
    | Example:
    |       "power" => "is-on"
    |
    */

    'fallback' => [
        //
    ],

];
```

## Usage

```php
// Create / update setting or settings
// Settings will automatically update database and replace cache
settings(['key' => 'value']);


// Create / update multple
settings([
   'key 1' => 'value 1',
   'key 2' => 'value 2',
   'key 3' => 'value 3',
   // etc 
]);


// Get
settings('key');

```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mikael@dalholm.se instead of using the issue tracker.

## Credits

-   [Mikael Dalholm](https://github.com/dalholm)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
