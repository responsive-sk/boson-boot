<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | This option controls the default theme that will be used by your
    | application. You may change this to any of the available themes.
    |
    */

    'default' => env('THEME', 'tailwind'),

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | Here you may specify all the themes available for your application.
    | Each theme should have its own configuration with asset paths.
    |
    */

    'available' => [
        'svelte' => [
            'name' => 'Svelte',
            'description' => 'Modern reactive components with Svelte',
            'framework' => 'svelte',
            'assets_path' => 'templates/assets/svelte',
            'build_path' => 'public/assets/svelte',
        ],
        
        'tailwind' => [
            'name' => 'Tailwind CSS',
            'description' => 'Utility-first CSS framework',
            'framework' => 'tailwind',
            'assets_path' => 'templates/assets/tailwind',
            'build_path' => 'public/assets/tailwind',
        ],
        
        'bootstrap' => [
            'name' => 'Bootstrap',
            'description' => 'Popular CSS framework',
            'framework' => 'bootstrap',
            'assets_path' => 'templates/assets/bootstrap',
            'build_path' => 'public/assets/bootstrap',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for theme assets including versioning and CDN settings.
    |
    */

    'assets' => [
        'public_path' => env('THEME_ASSETS_PATH', '/assets'),
        'version' => env('THEME_ASSETS_VERSION', '1.0.0'),
        'cache_busting' => env('THEME_CACHE_BUSTING', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for theme development including hot reload and build tools.
    |
    */

    'development' => [
        'hot_reload' => env('THEME_HOT_RELOAD', false),
        'dev_server_ports' => [
            'svelte' => 5173,
            'tailwind' => 5174,
            'bootstrap' => 5175,
        ],
    ],
];
