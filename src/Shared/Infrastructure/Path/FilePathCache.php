<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Path;

use Boson\Shared\Infrastructure\PathManager;

/**
 * File-based path cache implementation
 */
class FilePathCache implements PathCacheInterface
{
    private string $cacheDir;
    private array $cache = [];
    private array $stats = [
        'hits' => 0,
        'misses' => 0,
        'sets' => 0,
        'deletes' => 0,
        'size' => 0
    ];

    public function __construct(?string $cacheDir = null)
    {
        if ($cacheDir === null) {
            // Use direct path construction to avoid circular dependency with PathManager
            $projectRoot = dirname(__DIR__, 4); // Go up 4 levels from src/Shared/Infrastructure/Path/
            $cacheDir = $projectRoot . '/storage/cache/paths';
        }
        $this->cacheDir = $cacheDir;
        $this->ensureCacheDirectory();
        $this->loadCache();
    }

    public function get(string $key): ?string
    {
        if (isset($this->cache[$key])) {
            $this->stats['hits']++;
            return $this->cache[$key];
        }

        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $data = unserialize(file_get_contents($cacheFile));
            if ($data && isset($data['expires']) && ($data['expires'] === 0 || $data['expires'] > time())) {
                $this->cache[$key] = $data['path'];
                $this->stats['hits']++;
                return $data['path'];
            } else {
                // Cache expired, clean up
                $this->delete($key);
            }
        }

        $this->stats['misses']++;
        return null;
    }

    public function set(string $key, string $path, ?int $ttl = null): void
    {
        $cacheFile = $this->getCacheFilePath($key);
        $data = [
            'path' => $path,
            'expires' => $ttl ? time() + $ttl : 0,
            'created' => time()
        ];

        $this->ensureCacheDirectory();
        file_put_contents($cacheFile, serialize($data), LOCK_EX);
        $this->cache[$key] = $path;
        $this->stats['sets']++;
        $this->stats['size'] = count($this->cache);
    }

    public function has(string $key): bool
    {
        if (isset($this->cache[$key])) {
            return true;
        }

        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $data = unserialize(file_get_contents($cacheFile));
            return $data && isset($data['expires']) && ($data['expires'] === 0 || $data['expires'] > time());
        }

        return false;
    }

    public function delete(string $key): void
    {
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        unset($this->cache[$key]);
        $this->stats['deletes']++;
        $this->stats['size'] = count($this->cache);
    }

    public function clear(): void
    {
        $files = glob($this->cacheDir . '/*.cache');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        $this->cache = [];
        $this->stats['deletes'] += count($files);
        $this->stats['size'] = 0;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    private function getCacheFilePath(string $key): string
    {
        $hash = md5($key);
        return $this->cacheDir . '/' . $hash . '.cache';
    }

    private function ensureCacheDirectory(): void
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    private function loadCache(): void
    {
        $files = glob($this->cacheDir . '/*.cache');
        foreach ($files as $file) {
            $data = unserialize(file_get_contents($file));
            if ($data && isset($data['expires']) && ($data['expires'] === 0 || $data['expires'] > time())) {
                $key = basename($file, '.cache');
                $this->cache[$key] = $data['path'];
            } else {
                // Clean up expired cache
                unlink($file);
            }
        }
        $this->stats['size'] = count($this->cache);
    }
}
