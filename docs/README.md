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
   ./bin/migrate
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
./bin/migrate                      # Setup database and seed data

# Cache management
./bin/cache-cleanup                # Clean expired cache entries
```

### Theme Development

```bash
# Install dependencies for each theme individually
cd templates/assets/svelte && pnpm install
cd templates/assets/tailwind && pnpm install  
cd templates/assets/bootstrap && pnpm install

# Build themes for production (individually)
cd templates/assets/svelte && pnpm run build
cd templates/assets/tailwind && pnpm run build
cd templates/assets/bootstrap && pnpm run build

# Development mode with hot reload
cd templates/assets/svelte && pnpm run dev      # Port 5173
cd templates/assets/tailwind && pnpm run dev    # Port 5174
cd templates/assets/bootstrap && pnpm run dev   # Port 5175
```

## Architecture

### Modern Kernel-Based Architecture

The application uses a modern **Kernel-based architecture** with middleware pipeline for maximum flexibility and maintainability.

#### Core Components

- **Kernel** - Application core managing the entire request lifecycle
- **Middleware Stack** - Modular request processing pipeline
- **Abstract Controllers** - Lightweight, trait-based controllers
- **Service Factory** - Centralized dependency injection
- **Error Handler** - Unified exception and error management
- **Session Manager** - Secure session handling with CSRF protection

### Directory Structure

```
src/
├── Blog/
│   ├── Application/          # Controllers and services
│   │   ├── *Controller.php   # Lightweight controllers extending AbstractController
│   │   └── *Service.php      # Business logic services
│   ├── Domain/              # Entities and repositories
│   └── Infrastructure/      # Database implementations
└── Shared/
    └── Infrastructure/      # Core infrastructure components
        ├── Kernel.php       # Application kernel (main entry point)
        ├── AbstractController.php  # Base controller with common functionality
        ├── ErrorHandler.php # Centralized error handling
        ├── SessionManager.php # Secure session management
        ├── RequestHandler.php # Request processing logic
        ├── Traits/          # Reusable controller traits
        │   ├── HasDatabase.php
        │   └── HasValidation.php
        └── Middleware/      # Middleware components
            ├── MiddlewareStack.php
            ├── SecurityHeadersMiddleware.php
            ├── RateLimitMiddleware.php
            └── RequestHandlerMiddleware.php

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

#### Application Kernel
- **Kernel**: Central application core managing request lifecycle
- **Environment Management**: Type-safe configuration loading with validation
- **Middleware Pipeline**: Modular request processing with configurable stack
- **Error Handling**: Centralized exception management with debug/production modes
- **Session Management**: Secure session handling with CSRF protection

#### Controllers & Services
- **Abstract Controllers**: Lightweight base controllers with common functionality
- **Controller Traits**: Modular functionality (HasDatabase, HasValidation)
- **Service Factory**: Centralized dependency injection and service creation
- **Request Handler**: Dedicated request processing and routing logic

#### Infrastructure
- **Router**: FastRoute with middleware support
- **Templates**: League Plates with caching
- **Database**: SQLite with query caching and FTS5 search
- **Security**: Multi-layer protection system
- **Performance**: Comprehensive optimization with singleton monitoring
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

- PHP 8.4+ with strict typing
- PSR-4 autoloading
- Domain-driven design principles
- Repository pattern for data access

### Kernel-Based Architecture

The application uses a modern kernel-based architecture with environment-driven configuration.

#### Application Kernel Usage

```php
// public/index.php - Ultra-clean entry point
<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Http\Kernel;

$kernel = new Kernel();
$kernel->run();
```

#### Environment Configuration

```env
# .env file
APP_NAME="Boson PHP"
APP_ENV=development
APP_DEBUG=true

# Middleware Configuration
ENABLE_LOGGING=true
ENABLE_RATE_LIMITING=false
RATE_LIMIT_MAX_ATTEMPTS=100
```

#### Adding Custom Middleware

```php
// Add middleware before kernel boots
$kernel = new Kernel();
$kernel->addMiddleware(new CustomMiddleware());
$kernel->run();

// Or extend Kernel class for complex setups
class CustomKernel extends Kernel
{
    protected function initializeMiddleware(): void
    {
        parent::initializeMiddleware();
        $this->middlewareStack->add(new CustomMiddleware());
    }
}
```

#### Controller Development

```php
// Lightweight controllers extending AbstractController
class BlogController extends AbstractController
{
    use HasDatabase, HasValidation;

    public function index(array $params = []): string
    {
        $posts = $this->query('SELECT * FROM posts ORDER BY created_at DESC');

        return $this->render('pages::blog', [
            'posts' => $posts,
            'pageTitle' => 'Blog Posts'
        ]);
    }

    public function create(array $params = []): string
    {
        // Validation with automatic error handling
        $error = $this->validateOrFail($_POST, [
            'title' => ['required', ['min', 3]],
            'content' => ['required', ['min', 10]]
        ]);

        if ($error) return $error; // Returns validation error fragment

        // Rate limiting
        if (!$this->checkRateLimit('post_create', 5, 3600)) {
            return $this->fragment('partials::rate-limit-error');
        }

        // Business logic
        $this->execute('INSERT INTO posts (title, content) VALUES (?, ?)', [
            $_POST['title'], $_POST['content']
        ]);

        return $this->redirect('/blog');
    }
}
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
3. Build theme assets: `cd templates/assets/[theme] && pnpm run build`
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
