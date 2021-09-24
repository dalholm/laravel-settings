<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Cache profile
    |--------------------------------------------------------------------------
    | This can be used to make your own logic
    |
    */
    'cache_profile' => Dalholm\LaravelSettings\Cache\CacheProfile::class,

    'cache_prefix' => 'laravel-settings',

    'cache_store' => 'redis',

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