<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Assets;

class AssetManager
{
    private string $currentTheme;
    private string $baseUrl;
    private string $version;
    private array $manifest = [];

    public function __construct(
        string $currentTheme = 'svelte',
        string $baseUrl = '/assets',
        string $version = '1.0.0'
    ) {
        $this->currentTheme = $currentTheme;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->version = $version;
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
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $this->asset($path);
        return file_exists($fullPath);
    }

    /**
     * Check if shared asset exists
     */
    public function sharedExists(string $path): bool
    {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $this->shared($path);
        return file_exists($fullPath);
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
        $themesDir = $_SERVER['DOCUMENT_ROOT'] . $this->baseUrl;
        if (!is_dir($themesDir)) {
            return ['svelte']; // Default fallback
        }

        $themes = [];
        $items = scandir($themesDir);
        
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..' && $item !== 'shared' && is_dir($themesDir . '/' . $item)) {
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
        $themeDir = $_SERVER['DOCUMENT_ROOT'] . $this->baseUrl . '/' . $this->currentTheme;

        if (is_dir($themeDir)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($themeDir)
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $relativePath = str_replace($themeDir . '/', '', $file->getPathname());
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
        $manifestPath = $_SERVER['DOCUMENT_ROOT'] . $this->baseUrl . '/' . $this->currentTheme . '/manifest.json';
        
        if (file_exists($manifestPath)) {
            $content = file_get_contents($manifestPath);
            $this->manifest = json_decode($content, true) ?: [];
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
}
