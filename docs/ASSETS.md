# Asset Management System

The Boson PHP application includes a comprehensive asset management system that provides theme-specific and shared asset handling with automatic fallbacks and performance optimizations.

## Overview

The asset management system is designed to:
- Organize assets by theme while allowing shared resources
- Provide automatic fallbacks from theme-specific to shared assets
- Enable cache busting with versioning
- Support performance optimizations like preloading
- Maintain clean separation between different theme assets

## Directory Structure

```
public/assets/
├── svelte/                 # Svelte theme assets
│   ├── fonts/             # Inter, JetBrains Mono fonts
│   ├── images/            # Theme-specific images
│   │   ├── articles/      # Article-related images
│   │   ├── heroes/        # Hero section backgrounds
│   │   └── icons/         # Theme-specific icons
│   ├── main.css           # Compiled Svelte styles
│   └── main.js            # Compiled Svelte components
├── tailwind/              # Tailwind theme assets
│   ├── fonts/
│   ├── images/
│   ├── main.css
│   └── main.js
├── bootstrap/             # Bootstrap theme assets
│   ├── fonts/
│   ├── images/
│   ├── main.css
│   └── main.js
└── shared/                # Cross-theme shared assets
    ├── images/
    │   ├── articles/      # Shared article images
    │   ├── logos/         # Brand logos and assets
    │   ├── placeholders/  # Fallback placeholder images
    │   └── icons/         # Shared icon sets
    └── fonts/             # Shared font files
```

## AssetManager Class

The `AssetManager` class provides the core functionality for asset handling.

### Basic Usage

```php
use Boson\Shared\Infrastructure\Assets\AssetManager;

// Initialize with current theme
$assetManager = new AssetManager('svelte', '/assets', '1.0.0');

// Theme-specific assets
$cssUrl = $assetManager->css();                    // /assets/svelte/main.css?v=1.0.0
$jsUrl = $assetManager->js();                      // /assets/svelte/main.js?v=1.0.0
$fontUrl = $assetManager->font('inter-400.woff2'); // /assets/svelte/fonts/inter-400.woff2?v=1.0.0

// Shared assets
$logoUrl = $assetManager->shared('images/logo.png');     // /assets/shared/images/logo.png?v=1.0.0
$iconUrl = $assetManager->sharedImage('icons/star.svg'); // /assets/shared/images/icons/star.svg?v=1.0.0
```

### Asset Methods

#### Theme-Specific Assets
```php
$assetManager->asset('path/to/file.ext')     // Generic theme asset
$assetManager->image('hero.jpg')             // Theme-specific image
$assetManager->font('inter-400.woff2')       // Theme-specific font
$assetManager->icon('chevron.svg')           // Theme-specific icon
$assetManager->css('main.css')               // Theme CSS file
$assetManager->js('main.js')                 // Theme JS file
```

#### Shared Assets
```php
$assetManager->shared('path/to/file.ext')    // Generic shared asset
$assetManager->sharedImage('logo.png')       // Shared image
```

#### Fallback System
```php
// Try theme-specific first, fallback to shared
$assetManager->assetWithFallback('images/hero.jpg', 'images/default-hero.jpg')

// Image with placeholder fallback
$assetManager->imageWithFallback('custom-hero.jpg', 'placeholder.jpg')
```

### Asset Existence Checking

```php
// Check if theme-specific asset exists
if ($assetManager->exists('images/custom-hero.jpg')) {
    $heroUrl = $assetManager->image('custom-hero.jpg');
}

// Check if shared asset exists
if ($assetManager->sharedExists('images/fallback.jpg')) {
    $fallbackUrl = $assetManager->sharedImage('fallback.jpg');
}
```

## ThemeManager Integration

The `ThemeManager` class includes built-in `AssetManager` integration for convenient access.

```php
// Get AssetManager instance
$assetManager = $themeManager->getAssetManager();

// Direct asset methods
$fontUrl = $themeManager->asset('fonts/inter-400.woff2');
$logoUrl = $themeManager->sharedAsset('images/logo.png');
$heroUrl = $themeManager->image('hero.jpg', 'placeholder.jpg');
```

## Performance Features

### Asset Preloading

```php
// Get critical assets for preloading
$preloadAssets = $assetManager->getPreloadAssets();
// Returns:
// [
//     'css' => '/assets/svelte/main.css?v=1.0.0',
//     'js' => '/assets/svelte/main.js?v=1.0.0',
//     'fonts' => [
//         '/assets/svelte/fonts/inter-400.woff2?v=1.0.0',
//         '/assets/svelte/fonts/inter-600.woff2?v=1.0.0'
//     ]
// ]
```

### Cache Busting

The system automatically adds version parameters to all asset URLs:
- Default versioning: `?v=1.0.0`
- Manifest-based versioning: `?v=abc12345` (file hash)

### Manifest Support

For advanced caching, the system supports manifest files:

```php
// Generate manifest for current theme
$manifest = $assetManager->generateManifest();

// Manifest includes file hashes for cache busting
// {
//     "main.css": {"size": 45678, "modified": 1640995200, "hash": "abc123..."},
//     "main.js": {"size": 123456, "modified": 1640995200, "hash": "def456..."}
// }
```

## Template Usage

### In PHP Templates

```php
// Using ThemeManager (recommended)
<link rel="stylesheet" href="<?= $themeManager->asset('main.css') ?>">
<script src="<?= $themeManager->asset('main.js') ?>" defer></script>

// Image with fallback
<img src="<?= $themeManager->image('hero.jpg', 'placeholder.jpg') ?>" alt="Hero">

// Shared assets
<img src="<?= $themeManager->sharedAsset('images/logo.png') ?>" alt="Logo">
```

### Preloading Critical Assets

```php
<?php $preloadAssets = $themeManager->getAssetManager()->getPreloadAssets(); ?>

<!-- Preload critical CSS -->
<link rel="preload" href="<?= $preloadAssets['css'] ?>" as="style">

<!-- Preload critical fonts -->
<?php foreach ($preloadAssets['fonts'] as $fontUrl): ?>
    <link rel="preload" href="<?= $fontUrl ?>" as="font" type="font/woff2" crossorigin>
<?php endforeach; ?>
```

## Best Practices

### Asset Organization

1. **Theme-Specific Assets**: Place in theme directories for customization
2. **Shared Assets**: Use for brand assets, common images, and fallbacks
3. **Naming Conventions**: Use descriptive names and consistent structure
4. **Image Optimization**: Optimize images for web (WebP, proper sizing)

### Performance Optimization

1. **Use Preloading**: Preload critical fonts and CSS
2. **Implement Fallbacks**: Always provide fallback images
3. **Cache Busting**: Use versioning for proper cache invalidation
4. **Lazy Loading**: Implement lazy loading for non-critical images

### Security Considerations

1. **CSP Compliance**: All assets are served from same origin
2. **File Validation**: Validate file types and sizes
3. **Path Traversal**: AssetManager prevents directory traversal
4. **Content Security**: Use appropriate security headers

## Migration from External Assets

When migrating from external asset sources (like Picsum Photos):

1. **Download Assets**: Save external assets locally
2. **Update References**: Change URLs to use AssetManager
3. **Implement Fallbacks**: Add placeholder images for missing assets
4. **Test CSP Compliance**: Ensure no external requests remain

Example migration:
```php
// Before (CSP violation)
<img src="https://picsum.photos/800/400?random=1" alt="Article">

// After (CSP compliant)
<img src="<?= $themeManager->sharedAsset('images/articles/getting-started.jpg') ?>" alt="Article">
```
