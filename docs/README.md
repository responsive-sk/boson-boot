# Boson PHP HTMX Application

A modern PHP application demonstrating Domain-Driven Design with HTMX, built with security and performance in mind.

## Features

- **HTMX Integration**: Server-side rendering with progressive enhancement
- **Asset Management**: Theme-specific and shared assets with automatic fallbacks
- **Full-Text Search**: SQLite FTS5 with live search functionality
- **Security**: CSP compliance, CSRF protection, rate limiting, and input validation
- **Performance**: Template caching, query caching, font preloading, and gzip compression
- **Middleware**: Modular middleware architecture
- **DDD Architecture**: Domain-driven design with repository pattern
- **Theme System**: Multiple frontend frameworks (Svelte, Tailwind, Bootstrap)
- **Testing**: PHPUnit, Behat, and PHPStan integration

## Requirements

- PHP 8.4 or higher
- SQLite with FTS5 support
- Node.js 18.0.0 or higher (for theme development)
- Web server (Apache/Nginx) or PHP built-in server
- Composer for dependency management

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd boson-php-htmx
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your settings
   ```

4. **Setup database**
   ```bash
   php migrate.php
   ```

5. **Start development server**
   ```bash
   php -S localhost:8080 -t public
   ```

## Configuration

Key environment variables in `.env`:

```env
# Application
APP_NAME="Boson PHP"
APP_ENV=development
APP_DEBUG=true

# Database
DB_DATABASE=./database/blog.sqlite

# Performance
TEMPLATE_CACHE=true
TEMPLATE_CACHE_TTL=3600

# Security
RATE_LIMIT_GLOBAL=100
RATE_LIMIT_API=30

# Theme System
THEME=tailwind  # Available: svelte, tailwind, bootstrap
```

## Usage

### Web Interface

- **Home**: `/` - Landing page with product information
- **Blog**: `/blog` - Blog posts with pagination
- **Search**: `/search` - Live search functionality
- **Documentation**: `/docs` - Product documentation

### API Endpoints

- **Search API**: `/api/search?q=term` - HTMX search endpoint
- **Blog Load More**: `/api/blog/load-more` - Pagination endpoint

### CLI Tools

```bash
# Database operations
php migrate.php                    # Setup database and seed data

# Cache management
php cache-manager.php stats        # Show cache statistics
php cache-manager.php clear        # Clear all caches
php cache-manager.php warmup       # Warm up template cache
php cache-manager.php cleanup      # Clean expired entries
```

### Theme Development

```bash
# Install theme dependencies
npm run install:themes

# Build all themes for production
npm run build:themes

# Development mode with hot reload
npm run dev:themes

# Individual theme development
npm run dev:svelte     # Port 5173
npm run dev:tailwind   # Port 5174
npm run dev:bootstrap  # Port 5175
```

## Architecture

### Directory Structure

```
src/
├── Blog/
│   ├── Application/          # Controllers and services
│   ├── Domain/              # Entities and repositories
│   └── Infrastructure/      # Database implementations
└── Shared/
    └── Infrastructure/      # Core infrastructure components

templates/                   # PHP Plates templates
├── assets/                  # Theme source files
│   ├── svelte/             # Svelte theme
│   ├── tailwind/           # Tailwind theme
│   └── bootstrap/          # Bootstrap theme
├── components/             # Reusable template components
├── layouts/                # Layout templates
├── pages/                  # Page templates
└── partials/               # Partial templates

public/                     # Web root with assets
├── assets/                 # Built theme assets
└── uploads/                # User uploaded files

storage/                    # Cache, sessions, logs
├── cache/                  # Application cache
├── logs/                   # Log files
├── sessions/               # Session files
└── templates/              # Template cache

database/                   # SQLite database files
├── migrations/             # Database migrations
└── seeders/                # Database seeders

tests/                      # Test files
├── Unit/                   # Unit tests
├── Integration/            # Integration tests
└── Feature/                # Feature tests
```

### Key Components

- **Router**: FastRoute with middleware support
- **Templates**: League Plates with caching
- **Database**: SQLite with query caching and FTS5 search
- **Security**: Multi-layer protection system
- **Performance**: Comprehensive optimization
- **Theme System**: Multiple frontend frameworks with Vite build pipeline
- **Testing**: PHPUnit, Behat, and PHPStan integration

## Security Features

- **File Protection**: .htaccess rules blocking sensitive files
- **Headers**: Security headers (XSS, CSRF, Clickjacking protection)
- **Input Validation**: Comprehensive validation with 15+ rules
- **Rate Limiting**: Configurable limits per endpoint
- **CSRF Protection**: One-time tokens with automatic expiration

## Performance Features

- **Template Caching**: File-based caching with TTL
- **Query Caching**: Database query result caching
- **Compression**: Gzip compression for responses
- **Monitoring**: Performance tracking and debugging

## Development

### Running Tests

```bash
# Run all tests
composer test:all

# Unit tests only
composer test:unit

# Integration tests only
composer test:integration

# Behat acceptance tests
composer test:behat

# Static analysis
composer analyse

# Code style check
composer cs:check

# Fix code style
composer cs:fix

# Run quality checks (analysis + style + tests)
composer quality
```

### Code Style

- PHP 8.1+ with strict typing
- PSR-4 autoloading
- Domain-driven design principles
- Repository pattern for data access

### Adding Middleware

```php
// Global middleware
$router->addGlobalMiddleware(new CustomMiddleware());

// Route-specific middleware
$router->addRouteMiddleware('/api/*', new ApiMiddleware());
```

### Cache Management

```php
// Clear specific cache
$cache = new FileCache('/path/to/cache');
$cache->clear();

// Template cache
$templateEngine->clearCache();
```

### Theme Management

```php
// Using ThemeManager
use Boson\Shared\Infrastructure\ThemeManager;

$themeManager = new ThemeManager('tailwind');

// Get theme assets
$cssUrl = $themeManager->getCssUrl();
$jsUrl = $themeManager->getJsUrl();

// Render theme assets in template
echo $themeManager->renderThemeAssets();

// Switch themes at runtime
$themeManager->setCurrentTheme('bootstrap');
```

## Deployment

### Production Setup

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Build theme assets: `npm run build:themes`
4. Configure web server with proper .htaccess rules
5. Set up HTTPS
6. Configure proper file permissions
7. Set up automated cache cleanup

### Web Server Configuration

**Apache**: Uses included .htaccess files
**Nginx**: Configure similar rules for file protection and compression

## Asset Management

The application includes a comprehensive asset management system similar to Laravel's asset helpers.

### Asset Structure

```
public/assets/
├── svelte/                 # Svelte theme assets
│   ├── fonts/             # Theme-specific fonts
│   ├── images/            # Theme-specific images
│   └── main.css/js        # Compiled theme files
├── tailwind/              # Tailwind theme assets
├── bootstrap/             # Bootstrap theme assets
└── shared/                # Cross-theme shared assets
    ├── images/
    │   ├── articles/      # Article images
    │   ├── logos/         # Brand assets
    │   └── placeholders/  # Fallback images
    └── icons/             # Shared icons
```

### AssetManager Usage

```php
// In controllers or templates
$assetManager = $themeManager->getAssetManager();

// Theme-specific assets
$assetManager->asset('images/hero.jpg')        // /assets/svelte/images/hero.jpg
$assetManager->font('inter-400.woff2')         // /assets/svelte/fonts/inter-400.woff2

// Shared assets
$assetManager->shared('images/logo.png')       // /assets/shared/images/logo.png
$assetManager->sharedImage('articles/demo.jpg') // /assets/shared/images/articles/demo.jpg

// With automatic fallbacks
$assetManager->imageWithFallback('hero.jpg', 'placeholder.jpg')

// Preload assets for performance
$preloadAssets = $assetManager->getPreloadAssets();
```

### ThemeManager Integration

```php
// Via ThemeManager (recommended)
$themeManager->asset('fonts/inter-400.woff2')
$themeManager->sharedAsset('images/logo.png')
$themeManager->image('hero.jpg', 'placeholder.jpg')
```

### Features

- **Theme Isolation**: Each theme has its own asset directory
- **Shared Assets**: Common assets available to all themes
- **Automatic Fallbacks**: Graceful degradation to shared assets
- **Cache Busting**: Automatic versioning for browser cache management
- **Preloading Support**: Performance optimization with asset preloading
- **Manifest Support**: Advanced caching with file hashes

## Contributing

1. Follow PSR-12 coding standards
2. Add tests for new features
3. Update documentation
4. Ensure security best practices

## License

This project is licensed under the MIT License.

## Support

For issues and questions:
- Check the documentation in `/docs`
- Review security guidelines in `SECURITY.md`
- Review theme system documentation in `THEMES.md`
- Review asset management in `ASSETS.md`
- Review performance optimization in `PERFORMANCE.md`
- Submit issues via the issue tracker
