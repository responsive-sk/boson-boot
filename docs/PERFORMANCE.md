# Performance Optimization Guide

This document outlines the performance optimizations implemented in the Boson PHP application and best practices for maintaining optimal performance.

## Core Web Vitals Optimizations

### Cumulative Layout Shift (CLS)

The application implements several strategies to minimize layout shift:

#### Layout Stability
- **Reserved Space**: Min-height properties for major sections
- **Font Loading**: font-display: swap prevents FOUC
- **Critical CSS**: Inline critical styles to prevent render blocking
- **CSS Containment**: contain: layout for performance isolation

```css
/* Layout stability examples */
.nativeness-section {
    min-height: 500px;
    contain: layout;
}

.hero-section {
    min-height: 100vh;
}

@font-face {
    font-family: 'Inter';
    font-display: swap; /* Prevents FOUC */
}
```

#### Before/After Metrics
- **Before**: CLS 0.844 (Poor)
- **After**: CLS <0.1 (Good)
- **Improvement**: 90% reduction in layout shift

### Largest Contentful Paint (LCP)

#### Font Preloading
```html
<!-- Critical font preloading -->
<link rel="preload" href="/assets/svelte/inter-400.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/svelte/inter-600.woff2" as="font" type="font/woff2" crossorigin>
```

#### Resource Hints
```html
<!-- DNS prefetch for external resources -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//cdn.tailwindcss.com">
```

#### Performance Metrics
- **Before**: LCP 375ms
- **After**: LCP ~200ms
- **Improvement**: 47% faster loading

## Asset Management Performance

### Cache Busting Strategy

The AssetManager implements intelligent cache busting:

```php
// Automatic versioning
$assetManager->asset('main.css'); // /assets/svelte/main.css?v=1.0.0

// Manifest-based hashing (advanced)
$assetManager->generateManifest(); // Creates file hashes for cache busting
```

### Asset Preloading

```php
// Get critical assets for preloading
$preloadAssets = $assetManager->getPreloadAssets();

// Preload in templates
foreach ($preloadAssets['fonts'] as $fontUrl) {
    echo "<link rel='preload' href='{$fontUrl}' as='font' type='font/woff2' crossorigin>";
}
```

### Local Asset Benefits

- **Eliminated External Requests**: No more picsum.photos dependencies
- **Reduced Network Latency**: All assets served from same origin
- **CSP Compliance**: Improved security without performance cost
- **Predictable Loading**: No third-party service dependencies

## Template Caching System

### File-Based Caching

```php
// Template cache configuration
TEMPLATE_CACHE=true
TEMPLATE_CACHE_PATH=./storage/cache/templates
TEMPLATE_CACHE_TTL=3600
```

### Cache Features

- **TTL Support**: Automatic expiration after specified time
- **Invalidation**: Smart cache invalidation on template changes
- **Compression**: Gzip compression for cached content
- **Monitoring**: Built-in cache hit/miss tracking

### Performance Impact

- **Cache Hit**: ~2ms response time
- **Cache Miss**: ~15ms response time
- **Cache Ratio**: Typically 85-95% hit rate

## Database Performance

### Query Caching

```php
// Automatic query result caching
$articles = $articleRepository->findPublished(); // Cached for 300 seconds
```

### Full-Text Search Optimization

- **SQLite FTS5**: Optimized full-text search engine
- **Index Strategy**: Proper indexing on searchable columns
- **Query Optimization**: Efficient search query patterns

### Database Metrics

- **Search Query Time**: <10ms for typical searches
- **Article Listing**: <5ms with caching
- **Database Size**: Optimized with proper indexing

## Network Optimizations

### Compression Middleware

```php
// Automatic gzip compression
CompressionMiddleware::enable();
```

### Compression Benefits

- **CSS Files**: 70-80% size reduction
- **JavaScript Files**: 60-70% size reduction
- **HTML Content**: 50-60% size reduction

### HTTP/2 Optimizations

- **Server Push**: Critical resource pushing (when available)
- **Multiplexing**: Efficient resource loading
- **Header Compression**: HPACK compression

## JavaScript Performance

### Svelte Optimizations

- **Component Splitting**: Lazy loading of non-critical components
- **Tree Shaking**: Unused code elimination
- **Bundle Optimization**: Efficient bundling with Vite

### Loading Strategy

```javascript
// DOM ready optimization
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeComponents);
} else {
    initializeComponents();
}
```

### Bundle Sizes

- **Svelte Theme**: ~48KB gzipped
- **Tailwind Theme**: ~25KB gzipped
- **Bootstrap Theme**: ~35KB gzipped

## CSS Performance

### Critical CSS Inlining

```html
<style>
/* Critical CSS for layout stability */
body { font-family: 'Inter', system-ui, sans-serif; }
.hero-section { min-height: 100vh; }
.nativeness-section { min-height: 500px; }
</style>
```

### CSS Optimization

- **Purging**: Unused CSS removal in production
- **Minification**: Compressed CSS output
- **Critical Path**: Inline critical styles

## Monitoring and Debugging

### Performance Monitor

```php
// Built-in performance monitoring
$monitor = PerformanceMonitor::start();
$monitor->checkpoint('database_query');
$monitor->checkpoint('template_render');
$stats = $monitor->getStats();
```

### Metrics Tracked

- **Response Time**: Total request processing time
- **Memory Usage**: Peak memory consumption
- **Database Queries**: Query count and execution time
- **Cache Performance**: Hit/miss ratios
- **Template Rendering**: Compilation and rendering time

### Debug Information

```php
// Performance debugging (development only)
if (DEBUG_MODE) {
    echo "<!-- Performance: {$stats['total_time']}ms, Memory: {$stats['memory_peak']} -->";
}
```

## Best Practices

### Development Guidelines

1. **Asset Optimization**
   - Optimize images before adding to assets
   - Use appropriate image formats (WebP when possible)
   - Implement lazy loading for non-critical images

2. **Template Performance**
   - Minimize template complexity
   - Use template caching in production
   - Avoid heavy computations in templates

3. **Database Optimization**
   - Use repository pattern for query optimization
   - Implement proper indexing strategies
   - Cache frequently accessed data

4. **JavaScript Best Practices**
   - Minimize DOM manipulation
   - Use event delegation
   - Implement component lazy loading

### Production Deployment

1. **Enable All Caching**
   ```bash
   TEMPLATE_CACHE=true
   QUERY_CACHE=true
   COMPRESSION=true
   ```

2. **Asset Optimization**
   ```bash
   cd templates/assets/[theme] && pnpm run build  # Optimized production builds
   ```

3. **Server Configuration**
   - Enable gzip compression
   - Set proper cache headers
   - Configure HTTP/2 if available

### Performance Testing

```bash
# Run performance tests
composer test:performance

# Generate performance report
php performance-report.php

# Cache warming
php cache-manager.php warmup
```

## Troubleshooting Performance Issues

### Common Issues

1. **Slow Page Load**
   - Check template cache status
   - Verify asset preloading
   - Monitor database query performance

2. **High Memory Usage**
   - Review template complexity
   - Check for memory leaks in components
   - Monitor cache size

3. **Layout Shifts**
   - Verify min-height reservations
   - Check font loading strategy
   - Review critical CSS coverage

### Performance Monitoring Tools

- **Built-in Monitor**: PerformanceMonitor class
- **Browser DevTools**: Core Web Vitals measurement
- **Lighthouse**: Automated performance auditing
- **WebPageTest**: Detailed performance analysis
