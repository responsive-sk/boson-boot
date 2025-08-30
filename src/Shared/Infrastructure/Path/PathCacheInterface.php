<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Path;

/**
 * Interface for path caching implementations
 */
interface PathCacheInterface
{
    /**
     * Get a cached path
     */
    public function get(string $key): ?string;

    /**
     * Set a path in cache
     */
    public function set(string $key, string $path, ?int $ttl = null): void;

    /**
     * Check if a path is cached
     */
    public function has(string $key): bool;

    /**
     * Remove a path from cache
     */
    public function delete(string $key): void;

    /**
     * Clear all cached paths
     */
    public function clear(): void;

    /**
     * Get cache statistics
     */
    public function getStats(): array;
}
