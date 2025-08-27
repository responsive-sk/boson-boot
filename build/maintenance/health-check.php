<?php
/**
 * Health Check Script for Shared Hosting
 */

echo "🔍 Health Check Report\n";
echo "=====================\n\n";

// PHP Version
echo "PHP Version: " . PHP_VERSION . "\n";

// Memory usage
echo "Memory Usage: " . memory_get_usage(true) / 1024 / 1024 . " MB\n";

// Disk space
$storageDir = __DIR__ . '/../storage';
if (is_dir($storageDir)) {
    $size = 0;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
    foreach ($files as $file) {
        $size += $file->getSize();
    }
    echo "Storage Size: " . round($size / 1024 / 1024, 2) . " MB\n";
}

// Check critical files
$criticalFiles = ['.env', 'src/', 'templates/', 'vendor/'];
foreach ($criticalFiles as $file) {
    $path = __DIR__ . '/../' . $file;
    echo $file . ": " . (file_exists($path) ? "✅ OK" : "❌ Missing") . "\n";
}

echo "\n✅ Health check completed\n";
