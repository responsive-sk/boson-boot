<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use ResponsiveSk\Slim4Paths\Paths;
use Boson\Shared\Infrastructure\Path\PathCacheInterface;
use Boson\Shared\Infrastructure\Path\PathResolverInterface;
use Boson\Shared\Infrastructure\Path\PathEventInterface;
use Boson\Shared\Infrastructure\Path\FilePathCache;
use Boson\Shared\Infrastructure\Path\PathEvent;

/**
 * Enhanced Path Manager for Boson PHP
 * 
 * Provides consistent path management across the entire application
 * with advanced features including caching, security validation,
 * custom resolvers, and event hooks.
 */
class PathManager
{
    private static ?Paths $pathManager = null;
    private static ?PathCacheInterface $cache = null;
    private static array $resolvers = [];
    private static array $listeners = [];
    private static bool $cacheEnabled = true;
    private static int $defaultCacheTtl = 3600; // 1 hour

    /**
     * Get the path manager instance
     */
    public static function getInstance(): Paths
    {
        if (self::$pathManager === null) {
            // Initialize with project root (4 levels up from this file)
            $projectRoot = dirname(__DIR__, 3);
            self::$pathManager = new Paths($projectRoot);
        }

        return self::$pathManager;
    }

    /**
     * Get the cache instance
     */
    public static function getCache(): PathCacheInterface
    {
        if (self::$cache === null) {
            // Create cache instance without using path resolution to avoid infinite loop
            $cacheDir = dirname(__DIR__, 3) . '/storage/cache/paths';
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            self::$cache = new FilePathCache($cacheDir);
        }

        return self::$cache;
    }

    /**
     * Set a custom cache implementation
     */
    public static function setCache(PathCacheInterface $cache): void
    {
        self::$cache = $cache;
    }

    /**
     * Enable or disable path caching
     */
    public static function setCacheEnabled(bool $enabled): void
    {
        self::$cacheEnabled = $enabled;
    }

    /**
     * Set default cache TTL in seconds
     */
    public static function setDefaultCacheTtl(int $ttl): void
    {
        self::$defaultCacheTtl = $ttl;
    }

    /**
     * Add a custom path resolver
     */
    public static function addResolver(PathResolverInterface $resolver): void
    {
        self::$resolvers[] = $resolver;
        // Sort resolvers by priority (highest first)
        usort(self::$resolvers, fn($a, $b) => $b->getPriority() <=> $a->getPriority());
    }

    /**
     * Add an event listener
     */
    public static function addListener(string $eventName, callable $listener, int $priority = 0): void
    {
        self::$listeners[$eventName][$priority][] = $listener;
        krsort(self::$listeners[$eventName]); // Higher priority first
    }

    /**
     * Remove event listeners
     */
    public static function removeListeners(string $eventName): void
    {
        unset(self::$listeners[$eventName]);
    }

    /**
     * Dispatch a path event
     */
    public static function dispatchEvent(PathEventInterface $event): void
    {
        $eventName = $event->getName();
        
        if (!isset(self::$listeners[$eventName])) {
            return;
        }

        foreach (self::$listeners[$eventName] as $priority => $listeners) {
            foreach ($listeners as $listener) {
                if ($event->isPropagationStopped()) {
                    break 2;
                }
                $listener($event);
            }
        }
    }

    /**
     * Get project root path with caching and events
     */
    public static function root(string $path = ''): string
    {
        return self::resolvePath('root', $path);
    }
    
    /**
     * Get storage path with caching and events
     */
    public static function storage(string $path = ''): string
    {
        return self::resolvePath('storage', $path);
    }
    
    /**
     * Get cache path with caching and events
     */
    public static function cache(string $path = ''): string
    {
        return self::resolvePath('cache', $path);
    }
    
    /**
     * Get logs path with caching and events
     */
    public static function logs(string $path = ''): string
    {
        return self::resolvePath('logs', $path);
    }

    /**
     * Get templates path with caching and events
     */
    public static function templates(string $path = ''): string
    {
        return self::resolvePath('templates', $path);
    }

    /**
     * Get public path with caching and events
     */
    public static function public(string $path = ''): string
    {
        return self::resolvePath('public', $path);
    }

    /**
     * Get vendor path with caching and events
     */
    public static function vendor(string $path = ''): string
    {
        return self::resolvePath('vendor', $path);
    }

    /**
     * Get source path with caching and events
     */
    public static function src(string $path = ''): string
    {
        return self::resolvePath('src', $path);
    }

    /**
     * Get sessions path with caching and events
     */
    public static function sessions(string $path = ''): string
    {
        return self::resolvePath('sessions', $path);
    }

    /**
     * Get uploads path with caching and events
     */
    public static function uploads(string $path = ''): string
    {
        return self::resolvePath('uploads', $path);
    }

    /**
     * Resolve a path with caching, custom resolvers, and events
     */
    private static function resolvePath(string $type, string $subPath = ''): string
    {
        $cacheKey = "path_{$type}_{$subPath}";

        // Try cache first
        if (self::$cacheEnabled) {
            $cachedPath = self::getCache()->get($cacheKey);
            if ($cachedPath !== null) {
                return $cachedPath;
            }
        }

        // Try custom resolvers
        foreach (self::$resolvers as $resolver) {
            if ($resolver->supports($type)) {
                $resolvedPath = $resolver->resolve($type, ['subPath' => $subPath]);
                
                // Validate resolved path - allow absolute paths
                $isAbsolute = str_starts_with($resolvedPath, '/') || preg_match('/^[a-zA-Z]:\\\\/', $resolvedPath);
                if (!self::validatePath($resolvedPath, $isAbsolute)) {
                    throw new \InvalidArgumentException("Invalid path resolved by custom resolver: $resolvedPath");
                }

                // Cache the result
                if (self::$cacheEnabled) {
                    self::getCache()->set($cacheKey, $resolvedPath, self::$defaultCacheTtl);
                }

                // Dispatch path resolved event
                self::dispatchEvent(new PathEvent('path.resolved', $resolvedPath, [
                    'type' => $type,
                    'subPath' => $subPath,
                    'resolver' => get_class($resolver)
                ]));

                return $resolvedPath;
            }
        }

        // Fall back to default implementation
        $path = match ($type) {
            'root' => self::getInstance()->buildPath($subPath),
            'storage' => self::getInstance()->buildPath('storage' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'cache' => self::storage('cache' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'logs' => self::storage('logs' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'templates' => self::getInstance()->buildPath('templates' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'public' => self::getInstance()->buildPath('public' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'vendor' => self::getInstance()->buildPath('vendor' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'src' => self::getInstance()->buildPath('src' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'sessions' => self::storage('sessions' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            'uploads' => self::storage('uploads' . ($subPath !== '' ? '/' . ltrim($subPath, '/') : '')),
            default => throw new \InvalidArgumentException("Unknown path type: $type")
        };

        // Validate the path - allow absolute paths
        $isAbsolute = str_starts_with($path, '/') || preg_match('/^[a-zA-Z]:\\\\/', $path);
        if (!self::validatePath($path, $isAbsolute)) {
            throw new \InvalidArgumentException("Invalid path generated: $path");
        }

        // Cache the result
        if (self::$cacheEnabled) {
            self::getCache()->set($cacheKey, $path, self::$defaultCacheTtl);
        }

        // Dispatch path resolved event
        self::dispatchEvent(new PathEvent('path.resolved', $path, [
            'type' => $type,
            'subPath' => $subPath,
            'method' => 'default'
        ]));

        return $path;
    }
    
    /**
     * Ensure directory exists with enhanced security and events
     */
    public static function ensureDirectory(string $path): string
    {
        // Validate path first
        if (!self::validatePath($path)) {
            throw new \InvalidArgumentException("Invalid path for directory creation: $path");
        }

        $fullPath = self::getInstance()->buildPath($path);

        // Dispatch before directory creation event
        $event = new PathEvent('directory.before_create', $fullPath);
        self::dispatchEvent($event);

        if (!$event->isPropagationStopped() && !is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
            
            // Dispatch after directory creation event
            self::dispatchEvent(new PathEvent('directory.created', $fullPath));
        }

        return $fullPath;
    }
    
    /**
     * Get relative path from project root with enhanced validation
     */
    public static function relative(string $absolutePath): string
    {
        if (!self::validatePath($absolutePath, true)) {
            throw new \InvalidArgumentException("Invalid absolute path: $absolutePath");
        }

        $root = self::root();
        
        if (str_starts_with($absolutePath, $root)) {
            return ltrim(substr($absolutePath, strlen($root)), '/');
        }
        
        return $absolutePath;
    }
    
    /**
     * Enhanced path security validation
     */
    public static function isSecure(string $path, bool $allowAbsolute = false): bool
    {
        // Basic security check - ensure path doesn't contain traversal
        $hasTraversal = str_contains($path, '..') || str_contains($path, '../');
        $isAbsolute = str_starts_with($path, '/') || preg_match('/^[a-zA-Z]:\\\\/', $path);
        
        // Check for null bytes and other dangerous patterns
        $hasNullBytes = str_contains($path, "\0");
        $hasControlChars = preg_match('/[\x00-\x1F\x7F]/', $path);
        
        if ($allowAbsolute) {
            return !$hasTraversal && !$hasNullBytes && !$hasControlChars;
        }
        
        return !$hasTraversal && !$isAbsolute && !$hasNullBytes && !$hasControlChars;
    }

    /**
     * Enhanced path sanitization
     */
    public static function sanitize(string $path): string
    {
        // Remove dangerous patterns
        $path = preg_replace(['/\.\.\//', '/\.\.\\\\/', '/\/\/+/', '/\\\\+/'], '', $path);
        
        // Remove null bytes and control characters
        $path = preg_replace('/[\x00-\x1F\x7F]/', '', $path);
        
        // Normalize directory separators
        $path = str_replace('\\', '/', $path);
        
        // Remove leading slashes and dots
        $path = ltrim($path, '/.');
        
        // Collapse multiple slashes
        $path = preg_replace('#/+#', '/', $path);
        
        return $path;
    }

    /**
     * Comprehensive path validation
     */
    public static function validatePath(string $path, bool $allowAbsolute = false): bool
    {
        // Check basic security
        if (!self::isSecure($path, $allowAbsolute)) {
            return false;
        }

        // Additional validation for absolute paths if allowed
        if ($allowAbsolute) {
            // Check if path is within project boundaries
            // Use direct path calculation to avoid circular dependency with cache
            $root = dirname(__DIR__, 3);
            if (!str_starts_with($path, $root)) {
                return false;
            }
        }

        // Check for valid path characters (more restrictive than filesystem)
        if (!preg_match('/^[a-zA-Z0-9_\-\.\/\\\:\@\s]+$/', $path)) {
            return false;
        }

        // Check maximum path length (prevent DOS)
        if (strlen($path) > 4096) {
            return false;
        }

        return true;
    }

    /**
     * Get cache statistics
     */
    public static function getCacheStats(): array
    {
        return self::getCache()->getStats();
    }

    /**
     * Clear path cache
     */
    public static function clearCache(): void
    {
        self::getCache()->clear();
    }

    /**
     * Get registered resolvers
     */
    public static function getResolvers(): array
    {
        return self::$resolvers;
    }

    /**
     * Get event listeners
     */
    public static function getListeners(?string $eventName = null): array
    {
        if ($eventName === null) {
            return self::$listeners;
        }

        return self::$listeners[$eventName] ?? [];
    }
}
