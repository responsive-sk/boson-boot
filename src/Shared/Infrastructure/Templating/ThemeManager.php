<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating;

use Boson\Shared\Infrastructure\Templating\Assets\AssetManager;

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
        $this->currentTheme = $currentTheme;
        $this->publicAssetsPath = $publicAssetsPath;
        $this->version = $version;
        $this->assetManager = new AssetManager($currentTheme, $publicAssetsPath, $version);
        $this->availableThemes = [
            'svelte' => [
                'name' => 'Svelte Components',
                'description' => 'Modern reactive components with Svelte',
                'css' => "/assets/svelte/main.css?v={$this->version}",
                'js' => "/assets/svelte/main.js?v={$this->version}",
                'framework' => 'svelte'
            ],
            'tailwind' => [
                'name' => 'Tailwind CSS',
                'description' => 'Utility-first CSS framework',
                'css' => "/assets/tailwind/main.css?v={$this->version}",
                'js' => "/assets/tailwind/main.js?v={$this->version}",
                'framework' => 'tailwind'
            ],
            'bootstrap' => [
                'name' => 'Bootstrap 5',
                'description' => 'Popular CSS framework',
                'css' => "/assets/bootstrap/main.css?v={$this->version}",
                'js' => "/assets/bootstrap/main.js?v={$this->version}",
                'framework' => 'bootstrap'
            ]
        ];
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
        if (!$this->isValidTheme($theme)) {
            throw new \InvalidArgumentException("Invalid theme: {$theme}");
        }
        
        $this->currentTheme = $theme;
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
            throw new \InvalidArgumentException("Invalid theme: {$theme}");
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
        $theme = $theme ?? $this->currentTheme;
        return "/assets/{$theme}/{$fontName}";
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
        // Look for manifest.json or similar to resolve hashed filenames
        $manifestPath = dirname($_SERVER['DOCUMENT_ROOT'] . $path) . '/manifest.json';
        
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $filename = basename($path);
            
            if (isset($manifest[$filename])) {
                return dirname($path) . '/' . $manifest[$filename];
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
}
