<?php
/**
 * Working Production Index
 * Simplified, bulletproof entry point
 */

// Clean output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Production settings
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../storage/logs/production.log');

// Disable problematic extensions
if (extension_loaded('xdebug')) {
    ini_set('xdebug.mode', 'off');
}

// Memory limits
ini_set('memory_limit', '128M');
ini_set('max_execution_time', '30');

// Start output buffering
ob_start();

// Send headers
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

try {
    // Check autoloader
    $autoloader = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($autoloader)) {
        throw new Exception('Autoloader not found');
    }
    
    require_once $autoloader;
    
    // Check environment
    $envFile = __DIR__ . '/../.env';
    if (!file_exists($envFile)) {
        throw new Exception('Environment file not found');
    }
    
    // Bootstrap kernel
    use Boson\Shared\Infrastructure\Http\Kernel;
    
    $kernel = new Kernel();
    echo $kernel->handle();
    
} catch (Throwable $e) {
    // Log error
    $logDir = __DIR__ . '/../storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    error_log(date('Y-m-d H:i:s') . ' - Error: ' . $e->getMessage() . "\n", 3, "$logDir/errors.log");
    
    // Show user-friendly error
    ob_end_clean();
    http_response_code(503);
    
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Boson PHP - Service Unavailable</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; margin: 0; padding: 40px; background: #f8f9fa; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .icon { font-size: 48px; margin-bottom: 20px; }
        .status { background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107; }
        .info { background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #17a2b8; }
        .footer { text-align: center; margin-top: 30px; color: #6c757d; font-size: 14px; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🔧</div>
            <h1>Service Temporarily Unavailable</h1>
        </div>
        
        <div class="status">
            <strong>We are currently experiencing technical difficulties.</strong><br>
            Our team has been notified and is working to resolve the issue.
        </div>
        
        <div class="info">
            <strong>What can you do?</strong>
            <ul>
                <li>Try refreshing the page in a few minutes</li>
                <li>Check back later - we are working on a fix</li>
                <li>Contact support if the issue persists</li>
            </ul>
        </div>
        
        <div style="text-align: center;">
            <a href="javascript:location.reload()" class="btn">Try Again</a>
        </div>
        
        <div class="footer">
            <p><strong>Boson PHP</strong></p>
            <small>Error logged at: ' . date('Y-m-d H:i:s') . '</small>
        </div>
    </div>
</body>
</html>';
}

// Flush output
if (ob_get_level()) {
    ob_end_flush();
}
?>
