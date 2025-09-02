<?php

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual view path has already been registered for you.
    |
    */

    'paths' => [
        'templates',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env('VIEW_COMPILED_PATH', 'storage/cache/templates'),

    /*
    |--------------------------------------------------------------------------
    | Template Engine Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the template engine including caching and extensions.
    |
    */

    'cache_enabled' => env('TEMPLATE_CACHE', true),
    'cache_ttl' => env('TEMPLATE_CACHE_TTL', 3600),
];
