# Boson PHP HTMX Application

A modern PHP application demonstrating desktop application documentation with HTMX, built with security and performance in mind.

## Features

- **HTMX Integration**: Server-side rendering with progressive enhancement
- **Full-Text Search**: SQLite FTS5 with live search functionality
- **Security**: Comprehensive protection with CSRF, rate limiting, and input validation
- **Performance**: Template caching, query caching, and gzip compression
- **Middleware**: Modular middleware architecture
- **DDD Architecture**: Domain-driven design with repository pattern

## Requirements

- PHP 8.1 or higher
- SQLite with FTS5 support
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
public/                     # Web root with assets
storage/                    # Cache, sessions, logs
database/                   # SQLite database files
```

### Key Components

- **Router**: FastRoute with middleware support
- **Templates**: League Plates with caching
- **Database**: SQLite with query caching
- **Security**: Multi-layer protection system
- **Performance**: Comprehensive optimization

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
php test_htmx_conversion.php
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

## Deployment

### Production Setup

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure web server with proper .htaccess rules
4. Set up HTTPS
5. Configure proper file permissions
6. Set up automated cache cleanup

### Web Server Configuration

**Apache**: Uses included .htaccess files
**Nginx**: Configure similar rules for file protection and compression

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
- Submit issues via the issue tracker
