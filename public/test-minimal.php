<?php
/**
 * Minimal Test Script
 * Tests basic PHP functionality without any framework
 */

// Disable all output buffering
while (ob_get_level()) {
    ob_end_clean();
}

// Disable compression
ini_set('zlib.output_compression', 0);

// Send headers immediately
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-cache');

?><!DOCTYPE html>
<html>
<head>
    <title>Minimal Test - Boson PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f0f0f0; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        .success { color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .info { color: #1565c0; background: #e3f2fd; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .warning { color: #ef6c00; background: #fff3e0; padding: 10px; border-radius: 4px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Minimal Test - Boson PHP</h1>
        
        <div class="success">
            <strong>✅ Basic PHP is working!</strong><br>
            This page loaded successfully without framework dependencies.
        </div>
        
        <h2>Server Information</h2>
        <table>
            <tr><th>PHP Version</th><td><?= PHP_VERSION ?></td></tr>
            <tr><th>Server Software</th><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></td></tr>
            <tr><th>Document Root</th><td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></td></tr>
            <tr><th>Script Name</th><td><?= $_SERVER['SCRIPT_NAME'] ?? 'Unknown' ?></td></tr>
            <tr><th>Request Method</th><td><?= $_SERVER['REQUEST_METHOD'] ?? 'Unknown' ?></td></tr>
            <tr><th>Request URI</th><td><?= $_SERVER['REQUEST_URI'] ?? 'Unknown' ?></td></tr>
        </table>
        
        <h2>PHP Configuration</h2>
        <table>
            <tr><th>Memory Limit</th><td><?= ini_get('memory_limit') ?></td></tr>
            <tr><th>Max Execution Time</th><td><?= ini_get('max_execution_time') ?></td></tr>
            <tr><th>Output Buffering</th><td><?= ini_get('output_buffering') ? 'ON' : 'OFF' ?></td></tr>
            <tr><th>Zlib Compression</th><td><?= ini_get('zlib.output_compression') ? 'ON' : 'OFF' ?></td></tr>
            <tr><th>Display Errors</th><td><?= ini_get('display_errors') ? 'ON' : 'OFF' ?></td></tr>
        </table>
        
        <h2>Extension Status</h2>
        <table>
            <?php
            $extensions = ['xdebug', 'zlib', 'opcache', 'apcu', 'pdo', 'pdo_sqlite'];
            foreach ($extensions as $ext): ?>
            <tr>
                <th><?= $ext ?></th>
                <td><?= extension_loaded($ext) ? '✅ Loaded' : '❌ Not Loaded' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>File System Check</h2>
        <table>
            <tr><th>Current Directory</th><td><?= getcwd() ?></td></tr>
            <tr><th>Autoloader</th><td><?= file_exists('../vendor/autoload.php') ? '✅ Found' : '❌ Missing' ?></td></tr>
            <tr><th>.env File</th><td><?= file_exists('../.env') ? '✅ Found' : '❌ Missing' ?></td></tr>
            <tr><th>Storage Directory</th><td><?= is_dir('../storage') ? '✅ Found' : '❌ Missing' ?></td></tr>
        </table>
        
        <h2>Memory Usage</h2>
        <table>
            <tr><th>Current Usage</th><td><?= round(memory_get_usage(true) / 1024 / 1024, 2) ?> MB</td></tr>
            <tr><th>Peak Usage</th><td><?= round(memory_get_peak_usage(true) / 1024 / 1024, 2) ?> MB</td></tr>
        </table>
        
        <div class="info">
            <strong>💡 Next Steps:</strong><br>
            If this page works but your main site doesn't, the issue is likely in:
            <ul>
                <li>Framework initialization</li>
                <li>Database connection</li>
                <li>Template rendering</li>
                <li>Specific PHP extensions</li>
            </ul>
        </div>
        
        <div class="warning">
            <strong>⚠️ Production Note:</strong><br>
            Delete this file after testing: <code>rm test-minimal.php</code>
        </div>
        
        <hr>
        <small>Generated at: <?= date('Y-m-d H:i:s') ?></small>
    </div>
</body>
</html>
