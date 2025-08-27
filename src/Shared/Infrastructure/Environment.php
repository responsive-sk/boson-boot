<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

/**
 * Environment variable loader and accessor
 */
class Environment
{
    private static bool $loaded = false;
    private static array $cache = [];

    /**
     * Load environment variables from .env file
     */
    public static function load(string $path): void
    {
        if (self::$loaded) {
            return; // Already loaded
        }

        if (!file_exists($path)) {
            throw new \RuntimeException("Environment file not found: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = self::parseValue(trim($value));

                // Only set if not already defined
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }

                // Cache for faster access
                self::$cache[$name] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Get environment variable with optional default
     */
    public static function get(string $key, $default = null): mixed
    {
        // Check cache first
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        // Check various sources
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        
        if ($value === false || $value === null) {
            return $default;
        }

        // Cache the result
        self::$cache[$key] = $value;
        
        return $value;
    }

    /**
     * Get environment variable as string
     */
    public static function getString(string $key, string $default = ''): string
    {
        return (string) self::get($key, $default);
    }

    /**
     * Get environment variable as integer
     */
    public static function getInt(string $key, int $default = 0): int
    {
        return (int) self::get($key, $default);
    }

    /**
     * Get environment variable as boolean
     */
    public static function getBool(string $key, bool $default = false): bool
    {
        $value = self::get($key, $default);
        
        if (is_bool($value)) {
            return $value;
        }

        return in_array(strtolower((string) $value), ['true', '1', 'yes', 'on'], true);
    }

    /**
     * Get environment variable as array (comma-separated)
     */
    public static function getArray(string $key, array $default = []): array
    {
        $value = self::get($key);
        
        if ($value === null) {
            return $default;
        }

        if (is_array($value)) {
            return $value;
        }

        return array_map('trim', explode(',', (string) $value));
    }

    /**
     * Check if running in production environment
     */
    public static function isProduction(): bool
    {
        return self::getString('APP_ENV', 'production') === 'production';
    }

    /**
     * Check if running in development environment
     */
    public static function isDevelopment(): bool
    {
        return self::getString('APP_ENV', 'production') === 'development';
    }

    /**
     * Check if running in testing environment
     */
    public static function isTesting(): bool
    {
        return self::getString('APP_ENV', 'production') === 'testing';
    }

    /**
     * Check if debug mode is enabled
     */
    public static function isDebug(): bool
    {
        return self::getBool('APP_DEBUG', false);
    }

    /**
     * Get application name
     */
    public static function getAppName(): string
    {
        return self::getString('APP_NAME', 'Boson PHP');
    }

    /**
     * Get application URL
     */
    public static function getAppUrl(): string
    {
        return self::getString('APP_URL', 'http://localhost');
    }

    /**
     * Check if environment variable exists
     */
    public static function has(string $key): bool
    {
        return self::get($key) !== null;
    }

    /**
     * Set environment variable (for testing)
     */
    public static function set(string $key, $value): void
    {
        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
        self::$cache[$key] = $value;
    }

    /**
     * Clear cache (for testing)
     */
    public static function clearCache(): void
    {
        self::$cache = [];
        self::$loaded = false;
    }

    /**
     * Parse environment value (handle quotes, booleans, etc.)
     */
    private static function parseValue(string $value): string
    {
        // Remove surrounding quotes
        if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
            (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
            $value = substr($value, 1, -1);
        }

        // Handle escaped characters
        $value = str_replace(['\\n', '\\r', '\\t'], ["\n", "\r", "\t"], $value);

        return $value;
    }

    /**
     * Get all environment variables
     */
    public static function all(): array
    {
        return array_merge($_ENV, self::$cache);
    }

    /**
     * Validate required environment variables
     */
    public static function validateRequired(array $required): void
    {
        $missing = [];
        
        foreach ($required as $key) {
            if (!self::has($key)) {
                $missing[] = $key;
            }
        }

        if (!empty($missing)) {
            throw new \RuntimeException(
                'Missing required environment variables: ' . implode(', ', $missing)
            );
        }
    }
}
