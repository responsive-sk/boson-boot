# PSR-15 Middleware Support

This document describes the PSR-15 middleware implementation in the Boson framework, providing full compatibility with PSR-15 standards while maintaining backward compatibility with existing custom middlewares.

## Overview

The PSR-15 implementation allows you to:
- Use standard PSR-15 middlewares alongside existing custom middlewares
- Switch between PSR-15 mode and legacy mode seamlessly
- Leverage the PSR-7 HTTP message interfaces
- Maintain full backward compatibility

## Architecture

### Core Components

1. **PsrRequestAdapter** - Converts array-based requests to PSR-7 ServerRequestInterface
2. **PsrResponseAdapter** - Converts PSR-7 ResponseInterface to array-based responses
3. **Psr15MiddlewareAdapter** - Wraps custom middlewares to make them PSR-15 compatible
4. **Psr15RequestHandler** - PSR-15 compatible request handler
5. **Psr15MiddlewareStack** - Manages both PSR-15 and custom middlewares
6. **Psr15Kernel** - Main PSR-15 processing kernel
7. **Enhanced Kernel** - Updated main Kernel with PSR-15 support

## Usage

### Basic Setup

```php
use Boson\Shared\Infrastructure\Http\Kernel;

$kernel = new Kernel();

// Enable PSR-15 mode
$kernel->enablePsr15Mode();

// Add PSR-15 middlewares
$kernel->addPsr15Middleware(new YourPsr15Middleware());

// Add custom middlewares (automatically wrapped)
$kernel->addMiddleware(new YourCustomMiddleware());

// Run the application
$kernel->run();
```

### Creating PSR-15 Middlewares

```php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class YourPsr15Middleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Pre-processing
        $request = $request->withAttribute('custom', 'value');

        // Call next middleware
        $response = $handler->handle($request);

        // Post-processing
        return $response->withHeader('X-Processed', 'true');
    }
}
```

### Programmatic Usage

```php
// Handle PSR-7 requests directly
$psrResponse = $kernel->handlePsr7($psrRequest);

// Handle array-based requests
$arrayResponse = $kernel->handleArray($arrayRequest);
```

## Configuration

### Environment Variables

```bash
# Enable PSR-15 mode by default
PSR15_MODE=true

# Enable logging for PSR-15 middlewares
ENABLE_LOGGING=true
```

### Runtime Configuration

```php
$kernel = new Kernel();

// Check current mode
if ($kernel->isPsr15Mode()) {
    // PSR-15 mode is active
}

// Switch modes (before booting)
$kernel->enablePsr15Mode();
$kernel->disablePsr15Mode();
```

## Middleware Compatibility

### PSR-15 Middlewares

PSR-15 middlewares implement the `Psr\Http\Server\MiddlewareInterface`:

```php
interface MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface;
}
```

### Custom Middlewares

Existing custom middlewares continue to work unchanged:

```php
interface MiddlewareInterface
{
    public function handle(array $request, callable $next): array;
}
```

## Built-in PSR-15 Middlewares

### Psr15LoggingMiddleware

Provides PSR-15 compatible logging with detailed request/response information.

```php
use Boson\Shared\Infrastructure\Http\Psr15\Middleware\Psr15LoggingMiddleware;

$logger = $serviceFactory->getLogger();
$kernel->addPsr15Middleware(new Psr15LoggingMiddleware($logger));
```

## Migration Guide

### From Legacy to PSR-15

1. **Enable PSR-15 Mode:**
   ```php
   $kernel->enablePsr15Mode();
   ```

2. **Replace Custom Middlewares:**
   ```php
   // Old way
   $kernel->addMiddleware(new CustomMiddleware());

   // New way (PSR-15)
   $kernel->addPsr15Middleware(new Psr15Middleware());
   ```

3. **Update Request Handling:**
   ```php
   // PSR-7 request handling
   $response = $kernel->handlePsr7($psrRequest);

   // Array-based (still supported)
   $response = $kernel->handleArray($arrayRequest);
   ```

## Testing

### PSR-15 Middleware Testing

```php
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class YourMiddlewareTest extends TestCase
{
    public function testMiddlewareProcessing()
    {
        $middleware = new YourPsr15Middleware();
        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);

        // Configure mocks and test
        $response = $middleware->process($request, $handler);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
```

## Performance Considerations

- PSR-15 mode has minimal performance overhead due to adapter patterns
- Request/Response conversion is optimized for common use cases
- Middleware stacking is efficient for both PSR-15 and custom middlewares

## Best Practices

1. **Use PSR-15 for New Code** - Prefer PSR-15 interfaces for new middleware development
2. **Gradual Migration** - Migrate existing middlewares incrementally
3. **Test Thoroughly** - Ensure both PSR-15 and legacy modes work correctly
4. **Monitor Performance** - Compare performance between modes if needed

## Troubleshooting

### Common Issues

1. **Headers Already Sent** - Ensure PSR-15 mode is enabled before kernel boot
2. **Middleware Order** - PSR-15 middlewares are processed in addition to custom ones
3. **Type Compatibility** - Use appropriate adapters for type conversion

### Debugging

```php
// Check kernel mode
var_dump($kernel->isPsr15Mode());

// Get PSR-15 kernel instance
$psr15Kernel = $kernel->getPsr15Kernel();
```

## Examples

See `examples/psr15-demo.php` for a complete working example of PSR-15 integration.

## Standards Compliance

This implementation complies with:
- PSR-7 (HTTP Message Interfaces)
- PSR-15 (HTTP Server Request Handlers)
- PSR-3 (Logger Interface)
- PSR-11 (Container Interface)

## Future Enhancements

- Additional PSR-15 middlewares (CORS, CSRF, etc.)
- Middleware pipeline optimization
- Enhanced error handling for PSR-15 middlewares
- Integration with PSR-17 (HTTP Factories)
