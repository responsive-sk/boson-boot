<?php

declare(strict_types=1);

/**
 * Path Management Configuration
 * 
 * Configuration for the PathManager using responsive-sk/slim4-paths
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Path Caching
    |--------------------------------------------------------------------------
    |
    | Enable/disable path caching for better performance. When enabled,
    | resolved paths are cached to avoid repeated filesystem operations.
    |
    */
    'cache' => [
        'enabled' => ($_ENV['PATH_CACHE_ENABLED'] ?? 'true') === 'true',
        'ttl' => (int) ($_ENV['PATH_CACHE_TTL'] ?? 3600), // 1 hour
        'driver' => $_ENV['PATH_CACHE_DRIVER'] ?? 'file', // file, redis, memcached
    ],

    /*
    |--------------------------------------------------------------------------
    | Path Aliases
    |--------------------------------------------------------------------------
    |
    | Define custom path aliases that can be used throughout the application.
    | These are resolved by the PathManager and can include environment variables.
    |
    */
    'aliases' => [
        // Core application paths
        'app' => 'src',
        'config' => 'config',
        'database' => 'database',
        
        // Storage paths
        'storage' => 'storage',
        'cache' => 'storage/cache',
        'logs' => 'storage/logs',
        'sessions' => 'storage/sessions',
        'uploads' => 'storage/uploads',
        
        // Template paths
        'templates' => 'templates',
        'views' => 'templates',
        'layouts' => 'templates/layouts',
        'components' => 'templates/components',
        'partials' => 'templates/partials',
        'pages' => 'templates/pages',
        
        // Asset paths
        'assets' => 'public/assets',
        'themes' => 'templates/assets',
        
        // Build paths
        'build' => 'public/assets',
        'dist' => 'public/assets',
        
        // Test paths
        'tests' => 'tests',
        'coverage' => 'coverage',
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment-specific Paths
    |--------------------------------------------------------------------------
    |
    | Override paths based on the current environment. Useful for testing
    | or when different environments require different path structures.
    |
    */
    'environments' => [
        'testing' => [
            'database' => 'tests/fixtures/database',
            'storage' => 'tests/storage',
            'cache' => 'tests/storage/cache',
            'logs' => 'tests/storage/logs',
            'uploads' => 'tests/storage/uploads',
        ],
        
        'production' => [
            // Production-specific path overrides
            'logs' => $_ENV['LOG_PATH'] ?? 'storage/logs',
            'cache' => $_ENV['CACHE_PATH'] ?? 'storage/cache',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Path Validation
    |--------------------------------------------------------------------------
    |
    | Security settings for path validation. These help prevent directory
    | traversal attacks and ensure paths stay within allowed boundaries.
    |
    */
    'validation' => [
        'enabled' => ($_ENV['PATH_VALIDATION_ENABLED'] ?? 'true') === 'true',
        'strict_mode' => ($_ENV['PATH_VALIDATION_STRICT'] ?? 'false') === 'true',
        'allowed_extensions' => [
            'php', 'html', 'css', 'js', 'json', 'txt', 'md',
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
            'woff', 'woff2', 'ttf', 'eot',
        ],
        'blocked_patterns' => [
            '../',
            '..\\',
            '/etc/',
            '/var/',
            '/usr/',
            '/home/',
            '.env',
            '.git',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Path Resolvers
    |--------------------------------------------------------------------------
    |
    | Register custom path resolvers that can handle specific path patterns.
    | Resolvers are tried in order of priority (highest first).
    |
    */
    'resolvers' => [
        // Example: Theme-aware asset resolver
        // 'theme_assets' => [
        //     'class' => 'App\\Path\\Resolvers\\ThemeAssetResolver',
        //     'priority' => 100,
        //     'config' => [
        //         'theme_path' => 'templates/assets',
        //         'fallback_theme' => 'default',
        //     ],
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Path Event Listeners
    |--------------------------------------------------------------------------
    |
    | Register event listeners that respond to path-related events.
    | Useful for logging, monitoring, or custom path processing.
    |
    */
    'listeners' => [
        // Example: Path access logger
        // 'path.resolved' => [
        //     'App\\Path\\Listeners\\PathLogger@onPathResolved'
        // ],
        // 'path.missing' => [
        //     'App\\Path\\Listeners\\PathLogger@onPathMissing'
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Directory Permissions
    |--------------------------------------------------------------------------
    |
    | Default permissions for directories created by the PathManager.
    | These should be set according to your server's security requirements.
    |
    */
    'permissions' => [
        'directories' => 0755,
        'files' => 0644,
        'secure_directories' => 0750, // For sensitive directories like logs
        'secure_files' => 0640,       // For sensitive files
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Settings that affect PathManager performance and resource usage.
    |
    */
    'performance' => [
        'max_cache_entries' => (int) ($_ENV['PATH_MAX_CACHE_ENTRIES'] ?? 1000),
        'cache_cleanup_interval' => (int) ($_ENV['PATH_CACHE_CLEANUP_INTERVAL'] ?? 3600), // 1 hour
        'enable_path_monitoring' => ($_ENV['PATH_MONITORING_ENABLED'] ?? 'false') === 'true',
    ],
];
