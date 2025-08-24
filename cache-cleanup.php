<?php
/**
 * Cache Cleanup Script
 * Run this periodically to clean expired cache entries
 */

require_once __DIR__ . '/vendor/autoload.php';

use Boson\Shared\Infrastructure\Cache\FileCache;

try {
    echo "Starting cache cleanup...\n\n";

    $caches = [
        'templates' => new FileCache(__DIR__ . '/storage/templates'),
        'queries' => new FileCache(__DIR__ . '/storage/cache/queries'),
        'general' => new FileCache(__DIR__ . '/storage/cache')
    ];

    $totalDeleted = 0;

    foreach ($caches as $name => $cache) {
        echo "Cleaning {$name} cache...\n";
        
        if (method_exists($cache, 'cleanup')) {
            $deleted = $cache->cleanup();
            echo "  Deleted {$deleted} expired entries\n";
            $totalDeleted += $deleted;
        } else {
            echo "  Cache cleanup not supported for this cache type\n";
        }
    }

    echo "\nCache cleanup completed!\n";
    echo "Total expired entries deleted: {$totalDeleted}\n";

} catch (Exception $e) {
    echo "Cache cleanup failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
