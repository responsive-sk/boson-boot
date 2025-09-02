<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('uploads'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'url' => env('APP_URL') . '/uploads',
            'visibility' => 'public',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for file uploads including size limits and allowed types.
    |
    */

    'uploads' => [
        'path' => env('UPLOAD_PATH', './public/uploads'),
        'max_size' => env('UPLOAD_MAX_SIZE', 10485760), // 10MB in bytes
        'allowed_types' => explode(',', env('UPLOAD_ALLOWED_TYPES', 'jpg,jpeg,png,gif,webp')),
        'allowed_mimes' => [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg', 
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ],
    ],
];