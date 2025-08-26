<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use DateTime;
use Exception;
use League\Plates\Engine;

use function count;
use function dirname;
use function is_string;
use function strlen;

class TemplateEngineWithCache extends Engine
{
    private string $cachePath;

    private bool $cacheEnabled;

    private int $cacheTtl;

    public function __construct(
        string $directory,
        ?string $cachePath = null,
        bool $cacheEnabled = false,
        int $cacheTtl = 3600,
    ) {
        parent::__construct($directory);
        $this->cachePath    = $cachePath ?? __DIR__ . '/../../../storage/cache/templates';
        $this->cacheEnabled = $cacheEnabled;
        $this->cacheTtl     = $cacheTtl;

        // Register template folders
        $this->addFolder('layouts', $directory . '/layouts');
        $this->addFolder('pages', $directory . '/pages');
        $this->addFolder('partials', $directory . '/partials');
        $this->addFolder('components', $directory . '/components');

        // Register helper functions
        $this->registerHelpers();

        if ($cacheEnabled && !is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0o755, true);
        }
    }

    public function render($name, array $data = []): string
    {
        if (!$this->cacheEnabled) {
            return parent::render($name, $data);
        }

        $cacheKey  = $this->generateCacheKey($name, $data);
        $cacheFile = $this->cachePath . '/' . $cacheKey . '.cache';

        // Check if cache exists and is valid
        if ($this->isCacheValid($cacheFile)) {
            return file_get_contents($cacheFile);
        }

        // Render template and cache it
        $content = parent::render($name, $data);
        $this->cacheContent($cacheFile, $content);

        return $content;
    }

    public function clearCache(): bool
    {
        if (!is_dir($this->cachePath)) {
            return true;
        }

        $files   = glob($this->cachePath . '/*.cache');
        $success = true;

        foreach ($files as $file) {
            if (!unlink($file)) {
                $success = false;
            }
        }

        return $success;
    }

    public function setCacheEnabled(bool $enabled): void
    {
        $this->cacheEnabled = $enabled;
    }

    public function setCacheTtl(int $ttl): void
    {
        $this->cacheTtl = $ttl;
    }

    public function getCacheStats(): array
    {
        if (!is_dir($this->cachePath)) {
            return ['files' => 0, 'size' => 0];
        }

        $files     = glob($this->cachePath . '/*.cache');
        $totalSize = 0;

        foreach ($files as $file) {
            $totalSize += filesize($file);
        }

        return [
            'files'          => count($files),
            'size'           => $totalSize,
            'size_formatted' => $this->formatBytes($totalSize),
        ];
    }

    private function generateCacheKey(string $name, array $data): string
    {
        // Include template modification time for cache invalidation
        try {
            $template     = $this->make($name);
            $templatePath = $template->path();
            $mtime        = file_exists($templatePath) ? filemtime($templatePath) : 0;
        } catch (Exception $e) {
            $mtime = 0;
        }

        return md5($name . serialize($data) . $mtime);
    }

    private function isCacheValid(string $cacheFile): bool
    {
        if (!file_exists($cacheFile)) {
            return false;
        }

        return (time() - filemtime($cacheFile)) < $this->cacheTtl;
    }

    private function cacheContent(string $cacheFile, string $content): void
    {
        $dir = dirname($cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }

        file_put_contents($cacheFile, $content, LOCK_EX);
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    private function registerHelpers(): void
    {
        // HTML escaping helper
        $this->registerFunction('escapeHtml', static function ($text) {
            return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        });

        // URL helper
        $this->registerFunction('url', static function ($path = '') {
            $baseUrl = $_SERVER['REQUEST_SCHEME'] ?? 'http';
            $baseUrl .= '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        });

        // Asset helper
        $this->registerFunction('asset', static function ($path) {
            return '/assets/' . ltrim($path, '/');
        });

        // Date formatting helper
        $this->registerFunction('formatDate', static function ($date, $format = 'Y-m-d H:i:s') {
            if (is_string($date)) {
                $date = new DateTime($date);
            }

            return $date instanceof DateTime ? $date->format($format) : '';
        });

        // Truncate text helper
        $this->registerFunction('truncate', static function ($text, $length = 100, $suffix = '...') {
            if (strlen($text) <= $length) {
                return $text;
            }

            return substr($text, 0, $length) . $suffix;
        });
    }
}
