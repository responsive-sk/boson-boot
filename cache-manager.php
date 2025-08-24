<?php
/**
 * Cache Management Script
 * Provides cache operations: clear, stats, warmup
 */

require_once __DIR__ . '/vendor/autoload.php';

use Boson\Shared\Infrastructure\ServiceFactory;
use Boson\Shared\Infrastructure\TemplateEngineWithCache;
use Boson\Shared\Infrastructure\Cache\FileCache;

function showUsage(): void
{
    echo "Cache Manager\n";
    echo "Usage: php cache-manager.php [command]\n\n";
    echo "Commands:\n";
    echo "  clear     Clear all caches\n";
    echo "  stats     Show cache statistics\n";
    echo "  warmup    Warm up template cache\n";
    echo "  cleanup   Clean expired cache entries\n";
    echo "  help      Show this help message\n\n";
}

function clearCaches(): void
{
    echo "Clearing caches...\n";
    
    $caches = [
        'templates' => __DIR__ . '/storage/cache/templates',
        'queries' => __DIR__ . '/storage/cache/queries',
        'general' => __DIR__ . '/storage/cache'
    ];
    
    foreach ($caches as $name => $path) {
        if (is_dir($path)) {
            $cache = new FileCache($path);
            if ($cache->clear()) {
                echo "  {$name} cache cleared\n";
            } else {
                echo "  Failed to clear {$name} cache\n";
            }
        } else {
            echo "  {$name} cache directory not found\n";
        }
    }
    
    echo "Cache clearing completed!\n";
}

function showStats(): void
{
    echo "Cache Statistics\n";
    echo "================\n\n";
    
    $serviceFactory = new ServiceFactory();
    $templateEngine = $serviceFactory->createTemplateEngine();
    
    if ($templateEngine instanceof TemplateEngineWithCache) {
        $stats = $templateEngine->getCacheStats();
        echo "Template Cache:\n";
        echo "  Files: {$stats['files']}\n";
        echo "  Size: {$stats['size_formatted']}\n\n";
    }
    
    $caches = [
        'queries' => __DIR__ . '/storage/cache/queries',
        'general' => __DIR__ . '/storage/cache'
    ];
    
    foreach ($caches as $name => $path) {
        if (is_dir($path)) {
            $files = glob($path . '/*.cache');
            $totalSize = 0;
            
            foreach ($files as $file) {
                $totalSize += filesize($file);
            }
            
            echo ucfirst($name) . " Cache:\n";
            echo "  Files: " . count($files) . "\n";
            echo "  Size: " . formatBytes($totalSize) . "\n\n";
        }
    }
}

function warmupCache(): void
{
    echo "Warming up template cache...\n";
    
    $serviceFactory = new ServiceFactory();
    $templateEngine = $serviceFactory->createTemplateEngine();
    
    // Common templates to warm up
    $templates = [
        ['layout::master', ['title' => 'Test', 'content' => 'Test content']],
        ['layout::default', ['title' => 'Test', 'content' => 'Test content']],
        ['partials::header', []],
        ['partials::footer', []],
        ['components::button', ['text' => 'Test', 'href' => '#']],
    ];
    
    $warmed = 0;
    foreach ($templates as [$template, $data]) {
        try {
            $templateEngine->render($template, $data);
            $warmed++;
            echo "  Warmed: {$template}\n";
        } catch (Exception $e) {
            echo "  Failed: {$template} - {$e->getMessage()}\n";
        }
    }
    
    echo "Template cache warmup completed! ({$warmed} templates)\n";
}

function cleanupCache(): void
{
    echo "Cleaning up expired cache entries...\n";
    
    $caches = [
        'templates' => __DIR__ . '/storage/cache/templates',
        'queries' => __DIR__ . '/storage/cache/queries',
        'general' => __DIR__ . '/storage/cache'
    ];
    
    $totalDeleted = 0;
    
    foreach ($caches as $name => $path) {
        if (is_dir($path)) {
            $cache = new FileCache($path);
            if (method_exists($cache, 'cleanup')) {
                $deleted = $cache->cleanup();
                echo "  {$name}: {$deleted} expired entries deleted\n";
                $totalDeleted += $deleted;
            }
        }
    }
    
    echo "Cache cleanup completed! ({$totalDeleted} entries deleted)\n";
}

function formatBytes(int $bytes): string
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}

// Main execution
try {
    $command = $argv[1] ?? 'help';
    
    switch ($command) {
        case 'clear':
            clearCaches();
            break;
            
        case 'stats':
            showStats();
            break;
            
        case 'warmup':
            warmupCache();
            break;
            
        case 'cleanup':
            cleanupCache();
            break;
            
        case 'help':
        default:
            showUsage();
            break;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
