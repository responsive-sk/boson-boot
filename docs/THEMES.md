# Boson PHP Theme System

Modern theme system supporting multiple frontend frameworks with Vite build pipeline.

## Available Themes

### Svelte Theme
- **Framework**: Svelte 4 + Vite
- **Features**: Reactive components, modern JavaScript
- **Best for**: Interactive applications, component-based architecture

### Tailwind Theme
- **Framework**: Tailwind CSS 3 + Alpine.js
- **Features**: Utility-first CSS, minimal JavaScript
- **Best for**: Rapid prototyping, utility-based styling

### Bootstrap Theme
- **Framework**: Bootstrap 5 + Sass
- **Features**: Component library, responsive grid
- **Best for**: Traditional web applications, familiar patterns

## Quick Start

### 1. Install Dependencies
```bash
# Install all theme dependencies
npm run install:themes

# Or install individually
cd templates/assets/svelte && npm install
cd templates/assets/tailwind && npm install  
cd templates/assets/bootstrap && npm install
```

### 2. Build Themes
```bash
# Build all themes for production
npm run build:themes

# Or build individually
cd templates/assets/svelte && npm run build
```

### 3. Development Mode
```bash
# Watch all themes (runs on ports 5173, 5174, 5175)
npm run dev:themes

# Or watch individually
npm run dev:svelte    # Port 5173
npm run dev:tailwind  # Port 5174
npm run dev:bootstrap # Port 5175
```

## Directory Structure

```
templates/assets/
├── svelte/
│   ├── src/
│   │   ├── components/     # Svelte components
│   │   ├── styles/        # CSS/SCSS files
│   │   └── main.js        # Entry point
│   ├── package.json
│   └── vite.config.js
├── tailwind/
│   ├── src/
│   │   ├── styles.css     # Tailwind CSS
│   │   └── main.js        # Alpine.js setup
│   ├── package.json
│   ├── vite.config.js
│   └── tailwind.config.js
└── bootstrap/
    ├── src/
    │   ├── styles.scss    # Bootstrap SCSS
    │   └── main.js        # Bootstrap JS
    ├── package.json
    └── vite.config.js
```

## PHP Integration

### Using ThemeManager

```php
use Boson\Shared\Infrastructure\ThemeManager;

$themeManager = new ThemeManager('tailwind');

// Get theme assets
$cssUrl = $themeManager->getCssUrl();
$jsUrl = $themeManager->getJsUrl();

// Render theme assets in template
echo $themeManager->renderThemeAssets();
```

### Environment Configuration

```env
# .env
THEME=tailwind  # or svelte, bootstrap
APP_ENV=production
```

### Template Integration

```php
// In your layout template
<?php $themeManager = $factory->createThemeManager(); ?>
<html class="<?= $themeManager->getThemeClasses() ?>">
<head>
    <?= $themeManager->renderThemeAssets() ?>
</head>
```

## Development Workflow

### 1. Choose Your Theme
```bash
# Set environment variable
export THEME=svelte  # or tailwind, bootstrap
```

### 2. Start Development Server
```bash
# Start PHP server
php -S localhost:8080 -t public

# Start theme watcher (in another terminal)
npm run dev:svelte
```

### 3. Build for Production
```bash
npm run build:themes
```

## Built Assets

After building, assets are available in:
- `public/assets/svelte/`
- `public/assets/tailwind/`  
- `public/assets/bootstrap/`

Each contains:
- `main.[hash].js` - JavaScript bundle
- `styles.[hash].css` - CSS bundle
- `manifest.json` - Asset mapping (production)

## Theme Features

### Svelte Theme
- Reactive components
- Component-based architecture
- Modern ES modules
- Hot module replacement

### Tailwind Theme
- Utility-first CSS
- Alpine.js integration
- JIT compilation
- Custom design system

### Bootstrap Theme
- Component library
- Responsive grid system
- SCSS customization
- Bootstrap Icons

## Switching Themes

### Runtime Switching
```php
$themeManager->setCurrentTheme('bootstrap');
```

### Environment Switching
```bash
# Update .env
THEME=bootstrap

# Rebuild if needed
npm run build:themes
```

## Asset Management

Each theme has its own asset directory structure with support for shared assets.

### Theme Asset Structure

```
public/assets/{theme}/
├── fonts/              # Theme-specific fonts
├── images/             # Theme-specific images
│   ├── articles/       # Article-related images
│   ├── heroes/         # Hero backgrounds
│   └── icons/          # Theme icons
├── main.css            # Compiled styles
└── main.js             # Compiled scripts
```

### Shared Assets

```
public/assets/shared/
├── images/
│   ├── articles/       # Cross-theme article images
│   ├── logos/          # Brand assets
│   └── placeholders/   # Fallback images
└── icons/              # Shared icon sets
```

### Using Assets in Templates

```php
// Theme-specific assets
<link rel="stylesheet" href="<?= $themeManager->asset('main.css') ?>">
<img src="<?= $themeManager->asset('images/hero.jpg') ?>" alt="Hero">

// Shared assets
<img src="<?= $themeManager->sharedAsset('images/logo.png') ?>" alt="Logo">

// With automatic fallbacks
<img src="<?= $themeManager->image('custom-hero.jpg', 'placeholder.jpg') ?>" alt="Hero">
```

### Asset Features

- **Theme Isolation**: Each theme maintains separate assets
- **Automatic Fallbacks**: Graceful degradation to shared assets
- **Cache Busting**: Automatic versioning for browser cache
- **Performance**: Built-in preloading support
- **CSP Compliance**: All assets served from same origin

## Creating Custom Themes

1. Create new theme directory: `templates/assets/my-theme/`
2. Add `package.json` and `vite.config.js`
3. Register in `ThemeManager::$availableThemes`
4. Update build scripts

## Troubleshooting

### Assets Not Loading
- Check build output in `public/assets/`
- Verify theme is registered in ThemeManager
- Check file permissions

### Development Server Issues
- Ensure ports 5173-5175 are available
- Check Vite configuration
- Verify node_modules are installed

### Build Failures
- Check Node.js version (>=18.0.0)
- Clear node_modules and reinstall
- Check for syntax errors in config files
