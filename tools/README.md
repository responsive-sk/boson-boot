# Development Tools

This directory contains development and testing utilities for the Boson PHP project.

## Tools

### `cache-manager`
Comprehensive cache management for development.

```bash
./tools/cache-manager [command]
```

**Commands:**
- `clear` - Clear all caches
- `stats` - Show cache statistics
- `warmup` - Warm up template cache
- `cleanup` - Clean expired cache entries
- `help` - Show help message

**Examples:**
```bash
./tools/cache-manager clear    # Clear all caches
./tools/cache-manager stats    # Show cache statistics
./tools/cache-manager warmup   # Warm up caches
```

### `test-htmx`
HTMX functionality testing script.

```bash
./tools/test-htmx
```

**Purpose**: Tests HTMX integration and server functionality
**Checks:**
- Server connectivity
- Home page loading
- HTMX library presence
- Articles page functionality
- API endpoints
- Search functionality

**Requirements**: Server running on localhost:8080

## Legacy Scripts

The following `.php` files are legacy versions kept for reference:
- `cache-manager.php` - Use `./tools/cache-manager` instead
- `test_htmx_conversion.php` - Use `./tools/test-htmx` instead

## Usage in Development

```bash
# Start development server
php -S localhost:8080 -t public

# Test HTMX functionality
./tools/test-htmx

# Clear caches during development
./tools/cache-manager clear

# Check cache usage
./tools/cache-manager stats
```

## Integration with IDE

These tools can be integrated with your IDE as external tools or run configurations for easier development workflow.
