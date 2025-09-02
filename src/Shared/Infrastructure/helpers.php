<?php

declare(strict_types=1);

/**
 * Global Helper Functions
 */

if (!function_exists('env')) {
    /**
     * Get an environment variable value with optional default
     *
     * @param string $key The environment variable key
     * @param mixed $default The default value if key is not found
     * @return mixed The environment variable value or default
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Clean value - remove comments and whitespace
        if (is_string($value)) {
            $value = trim(explode('#', $value)[0]);
        }
        
        // Handle boolean values
        if (is_string($value)) {
            $lower = strtolower($value);
            if (in_array($lower, ['true', '1', 'yes', 'on'])) {
                return true;
            }
            if (in_array($lower, ['false', '0', 'no', 'off', ''])) {
                return false;
            }
        }
        
        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Get a configuration value using dot notation
     *
     * @param string $key Configuration key in dot notation (e.g., 'database.host')
     * @param mixed $default Default value if key is not found
     * @return mixed Configuration value or default
     */
    function config(string $key, mixed $default = null): mixed
    {
        static $config = [];
        static $cacheLoaded = false;
        
        // Load config if not already loaded
        if (empty($config)) {
            // Ensure Config is loaded first to populate $_ENV
            \Boson\Shared\Infrastructure\Config::getInstance();
            
            $configPath = dirname(__DIR__, 3) . '/config';
            $cacheFile = dirname(__DIR__, 3) . '/storage/cache/config.php';
            $cacheEnabled = ($_ENV['CONFIG_CACHE'] ?? 'false') === 'true';
            
            // Try to load from cache first
            if ($cacheEnabled && file_exists($cacheFile) && !$cacheLoaded) {
                $cachedConfig = include $cacheFile;
                if (is_array($cachedConfig)) {
                    $config = $cachedConfig;
                    $cacheLoaded = true;
                }
            }
            
            // Load from files if cache miss or disabled
            if (empty($config) && is_dir($configPath)) {
                $configFiles = glob($configPath . '/*.php');
                foreach ($configFiles as $file) {
                    $configKey = basename($file, '.php');
                    $configData = include $file;
                    if (is_array($configData)) {
                        $config[$configKey] = $configData;
                    }
                }
                
                // Save to cache if enabled
                if ($cacheEnabled && !empty($config)) {
                    $cacheDir = dirname($cacheFile);
                    if (!is_dir($cacheDir)) {
                        mkdir($cacheDir, 0755, true);
                    }
                    file_put_contents($cacheFile, '<?php return ' . var_export($config, true) . ';');
                }
            }
        }
        
        // Parse dot notation
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
}

if (!function_exists('app_path')) {
    /**
     * Get the application path
     */
    function app_path(string $path = ''): string
    {
        return dirname(__DIR__, 3) . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the storage path
     */
    function storage_path(string $path = ''): string
    {
        return app_path('storage' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the public path
     */
    function public_path(string $path = ''): string
    {
        return app_path('public' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}
