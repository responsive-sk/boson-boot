<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating;

use Boson\Shared\Infrastructure\Templating\Assets\AssetManager;
use Boson\Shared\Infrastructure\PathManager;
use InvalidArgumentException;

class ThemeManager
{
    private string $currentTheme;
    private array $availableThemes;
    private string $publicAssetsPath;
    private string $version;
    private AssetManager $assetManager;

    public function __construct(
        string $currentTheme = 'tailwind',
        string $publicAssetsPath = '/assets',
        string $version = '1.0.0'
    ) {
        $this->validateTheme($currentTheme);
        $this->validatePublicAssetsPath($publicAssetsPath);
        $this->validateVersion($version);

        $this->currentTheme = $currentTheme;
        $this->publicAssetsPath = rtrim($publicAssetsPath, '/');
        $this->version = $version;
        $this->assetManager = new AssetManager($currentTheme, $publicAssetsPath, $version);
        $this->initializeAvailableThemes();
    }

    /**
     * Initialize available themes with validation
     */
    private function initializeAvailableThemes(): void
    {
        $this->availableThemes = [
            'svelte' => [
                'name' => 'Svelte Components',
                'description' => 'Modern reactive components with Svelte',
                'css' => $this->buildAssetUrl('svelte', 'main.css'),
                'js' => $this->buildAssetUrl('svelte', 'main.js'),
                'framework' => 'svelte'
            ],
            'tailwind' => [
                'name' => 'Tailwind CSS',
                'description' => 'Utility-first CSS framework',
                'css' => $this->buildAssetUrl('tailwind', 'main.css'),
                'js' => $this->buildAssetUrl('tailwind', 'main.js'),
                'framework' => 'tailwind'
            ],
            'bootstrap' => [
                'name' => 'Bootstrap 5',
                'description' => 'Popular CSS framework',
                'css' => $this->buildAssetUrl('bootstrap', 'main.css'),
                'js' => $this->buildAssetUrl('bootstrap', 'main.js'),
                'framework' => 'bootstrap'
            ]
        ];
    }

    /**
     * Build secure asset URL
     */
    private function buildAssetUrl(string $theme, string $filename): string
    {
        $this->validateTheme($theme);
        $this->validateFilename($filename);

        return $this->publicAssetsPath . '/' . $theme . '/' . $filename . '?v=' . urlencode($this->version);
    }

    public function getCurrentTheme(): string
    {
        return $this->currentTheme;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setCurrentTheme(string $theme): void
    {
        $this->validateTheme($theme);

        if (!$this->isValidTheme($theme)) {
            throw new InvalidArgumentException("Invalid theme: {$theme}");
        }
        
        $this->currentTheme = $theme;
        $this->assetManager->setTheme($theme);
    }

    public function isValidTheme(string $theme): bool
    {
        return array_key_exists($theme, $this->availableThemes);
    }

    public function getAvailableThemes(): array
    {
        return $this->availableThemes;
    }

    public function getThemeConfig(?string $theme = null): array
    {
        $theme = $theme ?? $this->currentTheme;
        
        if (!$this->isValidTheme($theme)) {
            throw new InvalidArgumentException("Invalid theme: {$theme}");
        }
        
        return $this->availableThemes[$theme];
    }

    public function getThemeAssets(?string $theme = null): array
    {
        $config = $this->getThemeConfig($theme);
        
        return [
            'css' => $this->resolveAssetPath($config['css']),
            'js' => $this->resolveAssetPath($config['js']),
            'framework' => $config['framework']
        ];
    }

    public function getCssUrl(?string $theme = null): string
    {
        $assets = $this->getThemeAssets($theme);
        return $assets['css'];
    }

    public function getJsUrl(?string $theme = null): string
    {
        $assets = $this->getThemeAssets($theme);
        return $assets['js'];
    }

    public function getFontUrl(string $fontName, ?string $theme = null): string
    {
        $this->validateFilename($fontName);

        // Fonts are shared across themes, not theme-specific
        // Add /assets prefix to font URLs to match public path
        return $this->publicAssetsPath . '/fonts/' . $fontName;
    }

    public function getThemeFonts(?string $theme = null): array
    {
        $theme = $theme ?? $this->currentTheme;

        $fontConfigs = [
            'svelte' => [
                'inter-400' => 'inter-400.woff2',
                'inter-600' => 'inter-600.woff2',
                'inter-700' => 'inter-700.woff2',
                'jetbrains-400' => 'jetbrains-mono-400.woff2',
                'jetbrains-500' => 'jetbrains-mono-500.woff2',
                'roboto-400' => 'roboto-condensed-400.woff2',
                'roboto-500' => 'roboto-condensed-500.woff2',
                'roboto-600' => 'roboto-condensed-600.woff2',
                'roboto-700' => 'roboto-condensed-700.woff2'
            ],
            'tailwind' => [
                'inter-400' => 'inter-400.woff2',
                'inter-500' => 'inter-500.woff2',
                'inter-600' => 'inter-600.woff2',
                'inter-700' => 'inter-700.woff2',
                'jetbrains-400' => 'jetbrains-mono-400.woff2',
                'jetbrains-500' => 'jetbrains-mono-500.woff2'
            ],
            'bootstrap' => [
                'inter-400' => 'inter-400.woff2',
                'inter-500' => 'inter-500.woff2',
                'inter-600' => 'inter-600.woff2',
                'inter-700' => 'inter-700.woff2',
                'jetbrains-400' => 'jetbrains-mono-400.woff2',
                'jetbrains-500' => 'jetbrains-mono-500.woff2'
            ]
        ];

        return $fontConfigs[$theme] ?? [];
    }

    public function getFramework(?string $theme = null): string
    {
        $assets = $this->getThemeAssets($theme);
        return $assets['framework'];
    }

    private function resolveAssetPath(string $path): string
    {
        // In production, resolve to actual built files with hashes
        if ($this->isProduction()) {
            return $this->resolveHashedAsset($path);
        }
        
        return $path;
    }

    private function resolveHashedAsset(string $path): string
    {
        // Strip query string from path
        $pathWithoutQuery = parse_url($path, PHP_URL_PATH);
        if ($pathWithoutQuery === false) {
            return $path;
        }

        // Validate path for security
        $this->validateAssetPath($pathWithoutQuery);

        // Get filesystem path to manifest
        try {
            $publicPath = PathManager::public();
            $relativeDir = dirname($pathWithoutQuery);
            $manifestPath = $publicPath . $relativeDir . '/manifest.json';
        } catch (\Exception $e) {
            // Fallback to original path if PathManager fails
            return $path;
        }

        if (file_exists($manifestPath) && is_readable($manifestPath)) {
            $manifestContent = file_get_contents($manifestPath);
            if ($manifestContent !== false) {
                $manifest = json_decode($manifestContent, true);
                if (is_array($manifest)) {
                    $filename = basename($pathWithoutQuery);
                    if (isset($manifest[$filename])) {
                        return $relativeDir . '/' . $manifest[$filename] . (parse_url($path, PHP_URL_QUERY) ? '?' . parse_url($path, PHP_URL_QUERY) : '');
                    }
                }
            }
        }

        return $path;
    }

    private function isProduction(): bool
    {
        return ($_ENV['APP_ENV'] ?? 'development') === 'production';
    }

    public function renderThemeAssets(?string $theme = null): string
    {
        $assets = $this->getThemeAssets($theme);
        $framework = $assets['framework'];
        
        $html = '';
        
        // CSS
        $html .= sprintf('<link rel="stylesheet" href="%s">', $assets['css']);
        
        // Framework-specific setup
        switch ($framework) {
            case 'svelte':
                $html .= '<script type="module" src="' . $assets['js'] . '"></script>';
                break;
                
            case 'tailwind':
                $html .= '<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>';
                $html .= '<script type="module" src="' . $assets['js'] . '"></script>';
                break;
                
            case 'bootstrap':
                $html .= '<script type="module" src="' . $assets['js'] . '"></script>';
                break;
        }
        
        return $html;
    }

    public function getThemeClasses(?string $theme = null): string
    {
        $framework = $this->getFramework($theme);

        return match($framework) {
            'svelte' => 'theme-svelte',
            'tailwind' => 'theme-tailwind',
            'bootstrap' => 'theme-bootstrap',
            default => 'theme-default'
        };
    }

    /**
     * Get AssetManager instance
     */
    public function getAssetManager(): AssetManager
    {
        return $this->assetManager;
    }

    /**
     * Get asset URL using AssetManager
     */
    public function asset(string $path): string
    {
        return $this->assetManager->asset($path);
    }

    /**
     * Get shared asset URL
     */
    public function sharedAsset(string $path): string
    {
        return $this->assetManager->shared($path);
    }

    /**
     * Get image with fallback
     */
    public function image(string $path, string $fallback = 'placeholder.jpg'): string
    {
        return $this->assetManager->imageWithFallback($path, $fallback);
    }

    /**
     * Validate asset path for security
     */
    private function validateAssetPath(string $path): void
    {
        if (empty($path)) {
            throw new InvalidArgumentException('Asset path cannot be empty');
        }

        // Check for path traversal attempts
        if (strpos($path, '..') !== false || strpos($path, '\\') !== false) {
            throw new InvalidArgumentException('Asset path contains invalid characters');
        }

        // Ensure path starts with /assets
        if (!str_starts_with($path, $this->publicAssetsPath)) {
            throw new InvalidArgumentException('Asset path must be within public assets directory');
        }

        // Validate path length
        if (strlen($path) > 255) {
            throw new InvalidArgumentException('Asset path is too long');
        }

        // Validate filename characters
        if (!preg_match('#^[a-zA-Z0-9._/-]+$#', $path)) {
            throw new InvalidArgumentException('Asset path contains invalid characters');
        }
    }

    /**
     * Validate public assets path
     */
    private function validatePublicAssetsPath(string $path): void
    {
        if (empty($path)) {
            throw new InvalidArgumentException('Public assets path cannot be empty');
        }

        if (!str_starts_with($path, '/')) {
            throw new InvalidArgumentException('Public assets path must start with /');
        }

        if (strlen($path) > 100) {
            throw new InvalidArgumentException('Public assets path is too long');
        }

        if (!preg_match('#^/[a-zA-Z0-9._/-]*$#', $path)) {
            throw new InvalidArgumentException('Public assets path contains invalid characters');
        }
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
     * Validate filename
     */
    private function validateFilename(string $filename): void
    {
        if (empty($filename)) {
            throw new InvalidArgumentException('Filename cannot be empty');
        }

        // Check for path traversal
        if (strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
            throw new InvalidArgumentException('Filename contains invalid characters');
        }

        // Validate filename characters
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            throw new InvalidArgumentException('Filename contains invalid characters');
        }

        if (strlen($filename) > 100) {
            throw new InvalidArgumentException('Filename is too long');
        }
    }

    /**
     * Validate version string
     */
    private function validateVersion(string $version): void
    {
        if (empty($version)) {
            throw new InvalidArgumentException('Version cannot be empty');
        }

        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $version)) {
            throw new InvalidArgumentException('Version contains invalid characters');
        }

        if (strlen($version) > 20) {
            throw new InvalidArgumentException('Version is too long');
        }
    }
}
