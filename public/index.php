<?php
/**
 * EMERGENCY PRODUCTION INDEX
 * Minimal, bulletproof entry point
 */

// Disable ALL output before headers
while (ob_get_level()) {
    ob_end_clean();
}

// Start fresh output buffer
ob_start();

// Disable ALL problematic extensions and settings
error_reporting(0);
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "../storage/logs/emergency.log");

// Disable compression that might cause corruption
ini_set("zlib.output_compression", 0);
ini_set("output_buffering", 0);

// Disable Xdebug completely
if (extension_loaded("xdebug")) {
    ini_set("xdebug.mode", "off");
    ini_set("xdebug.start_with_request", "no");
}

// Memory limits for shared hosting
ini_set("memory_limit", "64M");
ini_set("max_execution_time", "15");

// Clean headers - send immediately
header("Content-Type: text/html; charset=UTF-8", true);
header("Cache-Control: no-cache, must-revalidate", true);
header("Pragma: no-cache", true);

// Flush headers immediately
if (function_exists("fastcgi_finish_request")) {
    // For PHP-FPM
    ob_end_flush();
    flush();
} else {
    // For other SAPIs
    ob_end_flush();
    flush();
}

// Start new buffer for content
ob_start();

try {
    // Minimal autoloader check
    $autoloader = __DIR__ . "/../vendor/autoload.php";
    if (!file_exists($autoloader)) {
        throw new Exception("Autoloader not found");
    }
    
    require_once $autoloader;
    
    // Minimal application bootstrap
    use Boson\Shared\Infrastructure\Http\Kernel;
    
    $kernel = new Kernel();
    $response = $kernel->handle();
    
    // Clean output
    echo $response;
    
} catch (Throwable $e) {
    // Emergency fallback page
    ob_end_clean();
    
    echo "<!DOCTYPE html>
<html>
<head>
    <title>Boson PHP - Maintenance</title>
    <meta charset=\"utf-8\">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; }
        .error { color: #d32f2f; background: #ffebee; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .info { color: #1976d2; background: #e3f2fd; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class=\"container\">
        <h1>🔧 Boson PHP - Temporary Maintenance</h1>
        <div class=\"info\">
            <strong>We are currently performing maintenance on this application.</strong><br>
            Please check back in a few minutes.
        </div>
        <div class=\"error\">
            <strong>Technical Details:</strong><br>
            " . htmlspecialchars($e->getMessage()) . "
        </div>
        <p>If you are the administrator:</p>
        <ul>
            <li>Check server error logs</li>
            <li>Verify file permissions</li>
            <li>Check database connectivity</li>
            <li>Review .env configuration</li>
        </ul>
        <hr>
        <small>Error logged at: " . date("Y-m-d H:i:s") . "</small>
    </div>
</body>
</html>";
    
    // Log the error
    error_log("Emergency fallback triggered: " . $e->getMessage());
}

// Final flush
if (ob_get_level()) {
    ob_end_flush();
}
?>