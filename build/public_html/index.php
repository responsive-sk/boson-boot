<?php
/**
 * Boson PHP - Production Entry Point
 * Optimized for shared hosting Apache
 */

// Production environment setup
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../storage/logs/php_errors.log');

// Disable Xdebug in production
if (extension_loaded('xdebug')) {
    ini_set('xdebug.mode', 'off');
}

// Output buffering for clean headers
ob_start();

// Memory and time limits for shared hosting
ini_set('memory_limit', '128M');
ini_set('max_execution_time', 30);

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Http\Kernel;

// Run the application
$kernel = new Kernel();
$kernel->run();

// Flush output buffer
if (ob_get_level()) ob_end_flush();
