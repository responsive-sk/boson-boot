<?php
/**
 * Boson PHP - Production Entry Point
 * Simplified for maximum compatibility
 */

// Disable problematic settings
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Disable Xdebug
if (extension_loaded('xdebug')) {
    ini_set('xdebug.mode', 'off');
}

// Basic autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Simple routing
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Remove query string
$uri = strtok($uri, '?');

// Basic routes
switch ($uri) {
    case '/':
        showHomePage();
        break;
    case '/articles':
        showArticlesPage();
        break;
    case '/test':
        showTestPage();
        break;
    default:
        show404();
        break;
}

function showHomePage() {
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Boson PHP - Go Native. Stay PHP.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .hero { text-align: center; padding: 80px 0; }
        .hero h1 { font-size: 3.5rem; margin-bottom: 20px; font-weight: 700; }
        .hero p { font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9; }
        .btn { display: inline-block; padding: 15px 30px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 8px; margin: 10px; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s; }
        .btn:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 60px; }
        .feature { background: rgba(255,255,255,0.1); padding: 30px; border-radius: 12px; backdrop-filter: blur(10px); }
        .feature h3 { margin-top: 0; font-size: 1.5rem; }
        .status { background: rgba(76, 175, 80, 0.2); padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #4caf50; }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <h1>🚀 Boson PHP</h1>
            <p>Go Native. Stay PHP.</p>

            <div class="status">
                <strong>✅ Application is running in simplified mode</strong><br>
                Basic functionality is available while we optimize the full framework.
            </div>

            <div>
                <a href="/articles" class="btn">📚 View Articles</a>
                <a href="/test" class="btn">🧪 Run Tests</a>
            </div>
        </div>

        <div class="features">
            <div class="feature">
                <h3>🏗️ Modern Architecture</h3>
                <p>Built with DDD, CQRS, and Clean Architecture principles for maintainable, scalable applications.</p>
            </div>
            <div class="feature">
                <h3>⚡ HTMX Integration</h3>
                <p>Dynamic user interfaces without complex JavaScript frameworks. Progressive enhancement at its finest.</p>
            </div>
            <div class="feature">
                <h3>🔒 Production Ready</h3>
                <p>Security hardened, performance optimized, and deployment ready for shared hosting environments.</p>
            </div>
        </div>
    </div>
</body>
</html>';
}

function showArticlesPage() {
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Articles - Boson PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; margin: 0; padding: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .article { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Articles</h1>
            <p>Explore our collection of articles about modern PHP development.</p>
            <a href="/" class="btn">← Back to Home</a>
        </div>

        <div class="article">
            <h2>Getting Started with Boson PHP</h2>
            <p>Learn the fundamentals of building applications with Boson PHP framework.</p>
            <small>Published: ' . date('Y-m-d') . '</small>
        </div>

        <div class="article">
            <h2>HTMX Integration Guide</h2>
            <p>Discover how to create dynamic interfaces using HTMX with minimal JavaScript.</p>
            <small>Published: ' . date('Y-m-d', strtotime('-1 day')) . '</small>
        </div>

        <div class="article">
            <h2>Deployment Best Practices</h2>
            <p>Production deployment strategies for shared hosting environments.</p>
            <small>Published: ' . date('Y-m-d', strtotime('-2 days')) . '</small>
        </div>
    </div>
</body>
</html>';
}

function showTestPage() {
    echo '<!DOCTYPE html>
<html>
<head>
    <title>System Test - Boson PHP</title>
    <meta charset="utf-8">
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #fff; }
        .success { color: #4caf50; }
        .error { color: #f44336; }
        .info { color: #2196f3; }
    </style>
</head>
<body>
    <h1>🧪 System Test Results</h1>

    <p class="success">✅ PHP Version: ' . PHP_VERSION . '</p>
    <p class="success">✅ Server: ' . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . '</p>
    <p class="success">✅ Memory Limit: ' . ini_get('memory_limit') . '</p>
    <p class="success">✅ Max Execution Time: ' . ini_get('max_execution_time') . 's</p>

    <h2>Extensions:</h2>
    <p class="' . (extension_loaded('pdo') ? 'success">✅' : 'error">❌') . ' PDO</p>
    <p class="' . (extension_loaded('json') ? 'success">✅' : 'error">❌') . ' JSON</p>
    <p class="' . (extension_loaded('mbstring') ? 'success">✅' : 'error">❌') . ' MBString</p>
    <p class="' . (extension_loaded('xdebug') ? 'info">⚠️' : 'success">✅') . ' Xdebug ' . (extension_loaded('xdebug') ? '(Loaded - should be disabled in production)' : '(Not loaded - good for production)') . '</p>

    <h2>File System:</h2>
    <p class="' . (file_exists('../vendor/autoload.php') ? 'success">✅' : 'error">❌') . ' Autoloader</p>
    <p class="' . (file_exists('../.env') ? 'success">✅' : 'error">❌') . ' Environment file</p>
    <p class="' . (is_writable('../storage') ? 'success">✅' : 'error">❌') . ' Storage writable</p>

    <p><a href="/" style="color: #2196f3;">← Back to Home</a></p>
</body>
</html>';
}

function show404() {
    http_response_code(404);
    echo '<!DOCTYPE html>
<html>
<head>
    <title>404 - Page Not Found</title>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; margin: 0; padding: 40px; background: #f8f9fa; text-align: center; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; }
        .icon { font-size: 64px; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔍</div>
        <h1>Page Not Found</h1>
        <p>The page you are looking for does not exist.</p>
        <a href="/" class="btn">Go Home</a>
    </div>
</body>
</html>';
}