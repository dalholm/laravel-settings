<?php

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

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache tag
    |--------------------------------------------------------------------------
    | Tag your settings cache with
    |
    */
];