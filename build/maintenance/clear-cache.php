<?php
/**
 * Clear Cache Script for Shared Hosting
 */

echo "🧹 Clearing cache...\n";

$cacheDir = __DIR__ . '/../storage/cache';
$cleared = 0;

if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $cleared++;
        }
    }
}

echo "✅ Cleared $cleared cache files\n";
