<?php
/**
 * Production Diagnostic Script
 * Run this to diagnose production issues
 */

header("Content-Type: text/plain");

echo "🔍 Production Diagnostic Report\n";
echo "==============================\n\n";

echo "Server Information:\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Server Software: " . ($_SERVER["SERVER_SOFTWARE"] ?? "Unknown") . "\n";
echo "Document Root: " . ($_SERVER["DOCUMENT_ROOT"] ?? "Unknown") . "\n";
echo "Script Name: " . ($_SERVER["SCRIPT_NAME"] ?? "Unknown") . "\n\n";

echo "PHP Configuration:\n";
echo "Memory Limit: " . ini_get("memory_limit") . "\n";
echo "Max Execution Time: " . ini_get("max_execution_time") . "\n";
echo "Output Buffering: " . (ini_get("output_buffering") ? "ON" : "OFF") . "\n";
echo "Zlib Compression: " . (ini_get("zlib.output_compression") ? "ON" : "OFF") . "\n";
echo "Display Errors: " . (ini_get("display_errors") ? "ON" : "OFF") . "\n\n";

echo "Loaded Extensions:\n";
$extensions = get_loaded_extensions();
foreach (["xdebug", "zlib", "opcache", "apcu"] as $ext) {
    echo "$ext: " . (in_array($ext, $extensions) ? "LOADED" : "NOT LOADED") . "\n";
}

echo "\nFile System:\n";
echo "Current Directory: " . getcwd() . "\n";
echo "Autoloader: " . (file_exists("../vendor/autoload.php") ? "EXISTS" : "MISSING") . "\n";
echo ".env: " . (file_exists("../.env") ? "EXISTS" : "MISSING") . "\n";

echo "\nOutput Buffer Status:\n";
echo "Buffer Level: " . ob_get_level() . "\n";
echo "Buffer Length: " . ob_get_length() . "\n";

echo "\nMemory Usage:\n";
echo "Current: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB\n";
echo "Peak: " . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . " MB\n";

echo "\n✅ Diagnostic completed\n";
?>