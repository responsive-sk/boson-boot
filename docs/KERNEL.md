# Kernel Architecture Documentation

Modern kernel-based architecture with middleware pipeline for maximum flexibility and maintainability.

## Overview

The Boson PHP application uses a **Kernel-based architecture** inspired by modern frameworks like Laravel and Symfony. This approach provides:

- **Single Entry Point**: Ultra-clean `index.php` with just 11 lines
- **Middleware Pipeline**: Modular request processing
- **Centralized Error Handling**: Unified exception management
- **Secure Session Management**: Built-in CSRF protection
- **Lightweight Controllers**: Trait-based functionality
- **Environment Management**: Type-safe configuration loading

## Core Components

### 1. Application Kernel

The `Kernel` class is the heart of the application, managing the entire request lifecycle.

```php
// src/Shared/Infrastructure/Kernel.php
class Kernel
{
    public function run(): void
    {
        $this->boot();                    // Initialize components
        $request = $this->createRequest(); // Build request object
        $response = $this->middlewareStack->handle($request); // Process through middleware
        $this->sendResponse($response);   // Send to client
        $this->terminate();              // Cleanup
    }
}
```

#### Key Features:
- **Environment Loading**: Automatic .env file processing
- **Automatic Bootstrapping**: Initializes all components
- **Request Object Creation**: Builds comprehensive request data
- **Middleware Orchestration**: Manages middleware pipeline
- **Response Handling**: Sends output to client
- **Cleanup Operations**: Post-response cleanup

### 2. Middleware Pipeline

Modular request processing with configurable middleware stack.

```php
// Default middleware stack (in order of execution)
$this->middlewareStack->add(new SecurityHeadersMiddleware()); // Security headers
$this->middlewareStack->add(new LoggingMiddleware());         // Request logging
$this->middlewareStack->add(new CompressionMiddleware());     // Response compression
$this->middlewareStack->add(new RateLimitMiddleware());       // Rate limiting
$this->middlewareStack->add(new RequestHandlerMiddleware()); // Route handling
```

#### Available Middleware:
- **SecurityHeadersMiddleware**: Sets security headers (XSS, CSRF, etc.)
- **LoggingMiddleware**: Request and performance logging
- **CompressionMiddleware**: Gzip/deflate compression
- **RateLimitMiddleware**: Request rate limiting
- **CorsMiddleware**: Cross-origin resource sharing
- **JsonMiddleware**: JSON response transformation
- **RequestHandlerMiddleware**: Route processing and controller execution

### 3. Abstract Controllers

Lightweight controllers with common functionality and trait-based extensions.

```php
// Base controller with automatic defaults
abstract class AbstractController
{
    protected function render(string $template, array $data = []): string
    protected function json(array $data, int $status = 200): string
    protected function fragment(string $template, array $data = []): string
    protected function redirect(string $url, int $status = 302): never
    protected function notFound(string $message = 'Page not found'): string
}
```

#### Controller Traits:
- **HasDatabase**: Database operations with error handling
- **HasValidation**: Input validation and rate limiting

### 4. Error Handling

Centralized exception management with debug/production modes.

```php
// Automatic error handling based on environment
if ($config->isDebug()) {
    $this->renderDebugError($e);    // Detailed debug interface
} else {
    $this->renderProductionError(); // User-friendly error page
}
```

#### Features:
- **Debug Mode**: Detailed error information with stack traces
- **Production Mode**: User-friendly error pages
- **Error Logging**: Automatic error logging
- **Custom Error Pages**: 404, 405, 500 templates

### 5. Session Management

Secure session handling with CSRF protection and security settings.

```php
// Automatic secure session configuration
SessionManager::start(); // Starts with HttpOnly, Secure, SameSite settings
$token = SessionManager::getCsrfToken(); // CSRF token generation
SessionManager::flash('message', 'Success!'); // Flash messages
```

#### Security Features:
- **HttpOnly Cookies**: Prevents XSS attacks
- **Secure Cookies**: HTTPS-only transmission
- **SameSite Protection**: CSRF protection
- **Session Regeneration**: Automatic ID regeneration
- **CSRF Tokens**: Built-in token generation

### 6. Environment Management

Type-safe configuration loading with validation and caching.

```php
// Environment variable access
Environment::getString('APP_NAME', 'Default App');
Environment::getInt('RATE_LIMIT_MAX_ATTEMPTS', 100);
Environment::getBool('APP_DEBUG', false);
Environment::getArray('CORS_ALLOWED_ORIGINS', ['*']);

// Environment checks
Environment::isProduction();  // true/false
Environment::isDevelopment(); // true/false
Environment::isDebug();       // true/false
```

#### Features:
- **Type Safety**: Dedicated getters for different data types
- **Default Values**: Fallback values for missing variables
- **Environment Detection**: Production/development/testing modes
- **Validation**: Required variable checking
- **Caching**: Performance optimization for repeated access

## Request Lifecycle

```mermaid
graph TD
    A[HTTP Request] --> B[Kernel::run()]
    B --> C[Kernel::boot()]
    C --> D[SessionManager::start()]
    D --> E[Initialize Middleware]
    E --> F[Create Request Object]
    F --> G[SecurityHeadersMiddleware]
    G --> H[CompressionMiddleware]
    H --> I[RateLimitMiddleware]
    I --> J[RequestHandlerMiddleware]
    J --> K[Router::dispatch()]
    K --> L[Controller Execution]
    L --> M[Template Rendering]
    M --> N[Response Compression]
    N --> O[Send Response]
    O --> P[Kernel::terminate()]
```

## Usage Examples

### Basic Application Setup

```php
// public/index.php
<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Http\Kernel;

$kernel = new Kernel();
$kernel->run();
```

### Environment Configuration

```env
# .env file
APP_NAME="Boson PHP"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8080

# Security Configuration
RATE_LIMIT_MAX_ATTEMPTS=100
RATE_LIMIT_WINDOW_SECONDS=300
ENABLE_RATE_LIMITING=false

# Logging Configuration
ENABLE_LOGGING=true
ERROR_LOG_FILE=./storage/logs/error.log
```

### Custom Middleware

```php
// Add custom middleware before boot
$kernel = new Kernel();
$kernel->addMiddleware(new LoggingMiddleware());
$kernel->addMiddleware(new AuthenticationMiddleware());
$kernel->run();
```

### Custom Kernel

```php
// Extend kernel for complex applications
class ApiKernel extends Kernel
{
    protected function initializeMiddleware(): void
    {
        // Custom middleware stack for API
        $this->middlewareStack->add(new CorsMiddleware());
        $this->middlewareStack->add(new JsonMiddleware());
        $this->middlewareStack->add(new AuthenticationMiddleware());
        $this->middlewareStack->add(new RequestHandlerMiddleware($this->serviceFactory));
    }
}
```

### Controller Development

```php
class ProductController extends AbstractController
{
    use HasDatabase, HasValidation;

    public function create(array $params = []): string
    {
        // Automatic validation with error handling
        $error = $this->validateOrFail($_POST, [
            'name' => ['required', ['min', 3]],
            'price' => ['required', 'numeric', ['min', 0]]
        ]);
        
        if ($error) return $error;
        
        // Rate limiting
        if (!$this->checkRateLimit('product_create', 10, 3600)) {
            return $this->rateLimitOrFail('product_create');
        }
        
        // Database operation
        $this->execute('INSERT INTO products (name, price) VALUES (?, ?)', [
            $_POST['name'], $_POST['price']
        ]);
        
        return $this->redirect('/products');
    }
}
```

## Benefits

### 1. Ultra-Clean Entry Point
- **11 lines** instead of 100+ lines in index.php
- **Single responsibility**: Just bootstrap and run
- **Zero business logic** in entry point

### 2. Modular Architecture
- **Middleware pipeline**: Easy to add/remove functionality
- **Trait-based controllers**: Reusable functionality
- **Service injection**: Clean dependency management

### 3. Developer Experience
- **Beautiful debug interface**: Stack traces, request info, actions
- **Automatic error handling**: No manual try/catch needed
- **Built-in validation**: Simple validation with automatic error responses

### 4. Security by Default
- **Secure sessions**: HttpOnly, Secure, SameSite
- **CSRF protection**: Automatic token generation
- **Rate limiting**: Built-in request limiting
- **Security headers**: XSS, clickjacking protection

### 5. Performance Optimized
- **Singleton monitoring**: Efficient performance tracking
- **Response compression**: Automatic gzip/deflate
- **FastCGI support**: Proper cleanup for PHP-FPM

## Migration from Old Architecture

### Before (Old index.php)
```php
// 118+ lines of mixed concerns
$router = new Router();
$serviceFactory = new ServiceFactory();
// ... rate limiting logic
// ... error handling logic
// ... response processing
// ... debug information
```

### After (New index.php)
```php
// 11 lines, single concern
<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Kernel;

$kernel = new Kernel();
$kernel->run();
```

## Testing

The kernel architecture makes testing much easier:

```php
// Test kernel components
$kernel = new Kernel();
$serviceFactory = $kernel->getServiceFactory();
$this->assertInstanceOf(ServiceFactory::class, $serviceFactory);

// Test middleware stack
$middlewareStack = $kernel->getMiddlewareStack();
$this->assertEquals(4, $middlewareStack->count());

// Test controller functionality
$controller = new TestController($templateEngine, $themeManager);
$response = $controller->index([]);
$this->assertStringContains('Expected content', $response);
```

## Best Practices

1. **Keep controllers lightweight** - Use traits for shared functionality
2. **Use middleware for cross-cutting concerns** - Authentication, logging, etc.
3. **Leverage automatic validation** - Use `validateOrFail()` for clean code
4. **Implement proper error handling** - Let the kernel handle exceptions
5. **Use session manager** - Don't manipulate `$_SESSION` directly
6. **Follow the middleware order** - Security first, then functionality
7. **Extend kernel for complex apps** - Create custom kernels for different contexts

## Troubleshooting

### Common Issues

1. **Middleware not executing**: Check if added before `$kernel->run()`
2. **Session issues**: Ensure HTTPS for secure cookies in production
3. **Validation errors**: Check trait usage and validation rules
4. **Template not found**: Verify template path and theme configuration
5. **Database errors**: Check trait usage and database configuration

### Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

This provides:
- Detailed error pages with stack traces
- Performance monitoring information
- Request/response debugging
- Middleware execution tracking
