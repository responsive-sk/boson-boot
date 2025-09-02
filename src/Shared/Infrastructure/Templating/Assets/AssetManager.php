<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating\Assets;

use Boson\Shared\Infrastructure\PathManager;
use InvalidArgumentException;

class AssetManager
{
    private string $currentTheme;
    private string $baseUrl;
    private string $version;
    private array $manifest = [];
    private string $documentRoot;

    public function __construct(
        string $currentTheme = 'svelte',
        string $baseUrl = '/assets',
        string $version = '1.0.0'
    ) {
        $this->validateTheme($currentTheme);
        $this->validateBaseUrl($baseUrl);

        $this->currentTheme = $currentTheme;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->version = $version;
        $this->documentRoot = $this->getSecureDocumentRoot();
        $this->loadManifest();
    }

    /**
     * Get theme-specific asset URL
     */
    public function asset(string $path): string
    {
        $fullPath = $this->baseUrl . '/' . $this->currentTheme . '/' . ltrim($path, '/');
        return $this->addVersion($fullPath);
    }

    /**
     * Get shared asset URL (cross-theme)
     */
    public function shared(string $path): string
    {
        $fullPath = $this->baseUrl . '/shared/' . ltrim($path, '/');
        return $this->addVersion($fullPath);
    }

    /**
     * Get theme-specific image
     */
    public function image(string $path): string
    {
        return $this->asset('images/' . ltrim($path, '/'));
    }

    /**
     * Get shared image
     */
    public function sharedImage(string $path): string
    {
        return $this->shared('images/' . ltrim($path, '/'));
    }

    /**
     * Get theme-specific font
     */
    public function font(string $path): string
    {
        return $this->asset('fonts/' . ltrim($path, '/'));
    }

    /**
     * Get theme-specific icon
     */
    public function icon(string $path): string
    {
        return $this->asset('icons/' . ltrim($path, '/'));
    }

    /**
     * Get CSS file with versioning
     */
    public function css(string $filename = 'main.css'): string
    {
        return $this->asset($filename);
    }

    /**
     * Get JS file with versioning
     */
    public function js(string $filename = 'main.js'): string
    {
        return $this->asset($filename);
    }

    /**
     * Check if asset exists
     */
    public function exists(string $path): bool
    {
        $this->validatePath($path);
        $fullPath = $this->documentRoot . $this->asset($path);
        return file_exists($fullPath) && is_readable($fullPath);
    }

    /**
     * Check if shared asset exists
     */
    public function sharedExists(string $path): bool
    {
        $this->validatePath($path);
        $fullPath = $this->documentRoot . $this->shared($path);
        return file_exists($fullPath) && is_readable($fullPath);
    }

    /**
     * Get asset with fallback to shared
     */
    public function assetWithFallback(string $path, ?string $fallbackPath = null): string
    {
        if ($this->exists($path)) {
            return $this->asset($path);
        }

        $fallback = $fallbackPath ?? $path;
        if ($this->sharedExists($fallback)) {
            return $this->shared($fallback);
        }

        // Return original path even if it doesn't exist (for debugging)
        return $this->asset($path);
    }

    /**
     * Get image with fallback to placeholder
     */
    public function imageWithFallback(string $path, string $placeholder = 'placeholder.jpg'): string
    {
        return $this->assetWithFallback('images/' . ltrim($path, '/'), 'images/' . $placeholder);
    }

    /**
     * Get all theme assets for preloading
     */
    public function getPreloadAssets(): array
    {
        return [
            'css' => $this->css(),
            'js' => $this->js(),
            'fonts' => [
                $this->font('inter-400.woff2'),
                $this->font('inter-600.woff2'),
            ]
        ];
    }

    /**
     * Set current theme
     */
    public function setTheme(string $theme): void
    {
        $this->currentTheme = $theme;
        $this->loadManifest();
    }

    /**
     * Get current theme
     */
    public function getCurrentTheme(): string
    {
        return $this->currentTheme;
    }

    /**
     * Get available themes
     */
    public function getAvailableThemes(): array
    {
        $themesDir = $this->documentRoot . $this->baseUrl;
        if (!is_dir($themesDir) || !is_readable($themesDir)) {
            return ['svelte']; // Default fallback
        }

        $themes = [];
        $items = scandir($themesDir);

        if ($items === false) {
            return ['svelte'];
        }

        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..' && $item !== 'shared' &&
                is_dir($themesDir . '/' . $item) && is_readable($themesDir . '/' . $item)) {
                $this->validateTheme($item);
                $themes[] = $item;
            }
        }

        return $themes ?: ['svelte'];
    }

    /**
     * Generate asset manifest for caching
     */
    public function generateManifest(): array
    {
        $manifest = [];
        $themeDir = $this->documentRoot . $this->baseUrl . '/' . $this->currentTheme;

        if (is_dir($themeDir) && is_readable($themeDir)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($themeDir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->isReadable()) {
                    $relativePath = str_replace($themeDir . '/', '', $file->getPathname());
                    $this->validatePath($relativePath);

                    $manifest[$relativePath] = [
                        'size' => $file->getSize(),
                        'modified' => $file->getMTime(),
                        'hash' => md5_file($file->getPathname())
                    ];
                }
            }
        }

        return $manifest;
    }

    /**
     * Add version parameter to URL
     */
    private function addVersion(string $url): string
    {
        $separator = strpos($url, '?') !== false ? '&' : '?';
        return $url . $separator . 'v=' . $this->version;
    }

    /**
     * Load asset manifest for cache busting
     */
    private function loadManifest(): void
    {
        $manifestPath = $this->documentRoot . $this->baseUrl . '/' . $this->currentTheme . '/manifest.json';

        if (file_exists($manifestPath) && is_readable($manifestPath)) {
            $content = file_get_contents($manifestPath);
            if ($content !== false) {
                $decoded = json_decode($content, true);
                $this->manifest = is_array($decoded) ? $decoded : [];
            }
        }
    }

    /**
     * Get asset URL with manifest hash
     */
    private function getVersionedUrl(string $path): string
    {
        $relativePath = str_replace($this->baseUrl . '/' . $this->currentTheme . '/', '', $path);

        if (isset($this->manifest[$relativePath]['hash'])) {
            $separator = strpos($path, '?') !== false ? '&' : '?';
            return $path . $separator . 'v=' . substr($this->manifest[$relativePath]['hash'], 0, 8);
        }

        return $this->addVersion($path);
    }

    /**
     * Get secure document root path
     */
    private function getSecureDocumentRoot(): string
    {
        // Try to get document root from PathManager first
        try {
            $path = PathManager::public();
            if (!empty($path) && is_dir($path)) {
                return rtrim($path, '/') . '/';
            }
        } catch (\Exception $e) {
            // Fall back to server variables
        }

        // Fallback to server variables with validation
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

        if (empty($documentRoot)) {
            throw new \RuntimeException('Document root could not be determined');
        }

        // Basic path validation
        if (!is_dir($documentRoot)) {
            throw new \RuntimeException('Document root directory does not exist: ' . $documentRoot);
        }

        return rtrim($documentRoot, '/') . '/';
    }

    /**
     * Validate theme name
     */
    private function validateTheme(string $theme): void
    {
        if (empty($theme)) {
            throw new InvalidArgumentException('Theme name cannot be empty');
        }

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $theme)) {
            throw new InvalidArgumentException('Theme name contains invalid characters');
        }

        if (strlen($theme) > 50) {
            throw new InvalidArgumentException('Theme name is too long');
        }
    }

    /**
     * Validate base URL
     */
    private function validateBaseUrl(string $baseUrl): void
    {
        if (empty($baseUrl)) {
            throw new InvalidArgumentException('Base URL cannot be empty');
        }

        if (!preg_match('#^/([a-zA-Z0-9._/-]*)$#', $baseUrl)) {
            throw new InvalidArgumentException('Base URL contains invalid characters or does not start with /');
        }

        if (strlen($baseUrl) > 100) {
            throw new InvalidArgumentException('Base URL is too long');
        }
    }

    /**
     * Validate file path for security
     */
    private function validatePath(string $path): void
    {
        if (empty($path)) {
            throw new InvalidArgumentException('Path cannot be empty');
        }

        // Check for path traversal attempts
        if (strpos($path, '..') !== false || strpos($path, '\\') !== false) {
            throw new InvalidArgumentException('Path contains invalid characters');
        }

        // Check for absolute paths
        if (strpos($path, '/') === 0) {
            throw new InvalidArgumentException('Absolute paths are not allowed');
        }

        // Validate path length
        if (strlen($path) > 255) {
            throw new InvalidArgumentException('Path is too long');
        }

        // Validate filename characters
        if (!preg_match('#^[a-zA-Z0-9._/-]+$#', $path)) {
            throw new InvalidArgumentException('Path contains invalid characters');
        }
    }
}
