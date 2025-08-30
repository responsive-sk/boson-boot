<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Caching;

use Boson\Shared\Infrastructure\PathManager;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use function dirname;
use function is_array;

class FileCache implements CacheInterface
{
    private string $cacheDir;

    public function __construct(?string $cacheDir = null)
    {
        $this->cacheDir = $cacheDir ?? PathManager::cache();

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0o755, true);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return $default;
        }

        $data = file_get_contents($file);
        if ($data === false) {
            return $default;
        }

        $cached = unserialize($data);

        if (!is_array($cached) || !isset($cached['expires'], $cached['data'])) {
            return $default;
        }

        if ($cached['expires'] > 0 && $cached['expires'] < time()) {
            $this->delete($key);

            return $default;
        }

        return $cached['data'];
    }

    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $file = $this->getFilePath($key);
        $dir  = dirname($file);

        if (!is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }

        $expires = $ttl > 0 ? time() + $ttl : 0;
        $data    = serialize([
            'expires' => $expires,
            'data'    => $value,
        ]);

        return file_put_contents($file, $data, LOCK_EX) !== false;
    }

    public function delete(string $key): bool
    {
        $file = $this->getFilePath($key);

        if (file_exists($file)) {
            return unlink($file);
        }

        return true;
    }

    public function clear(): bool
    {
        return $this->deleteDirectory($this->cacheDir);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function getMultiple(array $keys, mixed $default = null): array
    {
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }

        return $result;
    }

    public function setMultiple(array $values, int $ttl = 3600): bool
    {
        $success = true;

        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                $success = false;
            }
        }

        return $success;
    }

    public function deleteMultiple(array $keys): bool
    {
        $success = true;

        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                $success = false;
            }
        }

        return $success;
    }

    public function cleanup(): int
    {
        $deleted  = 0;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->cacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'cache') {
                $data = file_get_contents($file->getPathname());
                if ($data !== false) {
                    $cached = unserialize($data);
                    if (is_array($cached) && isset($cached['expires'])
                        && $cached['expires'] > 0 && $cached['expires'] < time()) {
                        unlink($file->getPathname());
                        ++$deleted;
                    }
                }
            }
        }

        return $deleted;
    }

    private function getFilePath(string $key): string
    {
        $hash = hash('sha256', $key);
        $dir  = substr($hash, 0, 2);

        return $this->cacheDir . '/' . $dir . '/' . $hash . '.cache';
    }

    private function deleteDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return true;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir . '/' . $file;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        return rmdir($dir);
    }
}
