<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Router;
use Boson\Shared\Infrastructure\ServiceFactory;
use Boson\Shared\Infrastructure\Performance\CompressionMiddleware;
use Boson\Shared\Infrastructure\Performance\PerformanceMonitor;
use Boson\Shared\Infrastructure\Security\RateLimiter;

// Start performance monitoring
$monitor = PerformanceMonitor::start();

// Enable compression
CompressionMiddleware::enable();

// Security headers
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Initialize services
$serviceFactory = new ServiceFactory();
$router = $serviceFactory->createRouter();

$monitor->checkpoint('bootstrap');

// Get request info
$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

// Remove query string and decode
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

try {
    // Basic rate limiting for the entire application
    $rateLimiter = new RateLimiter();
    $clientId = $rateLimiter->getClientIdentifier();

    if (!$rateLimiter->isAllowed($clientId, 100, 300)) { // 100 requests per 5 minutes
        http_response_code(429);
        header('Retry-After: ' . $rateLimiter->getTimeUntilReset($clientId, 300));
        echo json_encode(['error' => 'Too Many Requests']);
        exit;
    }

    $rateLimiter->recordAttempt($clientId);
    $monitor->checkpoint('rate_limit_check');

    // Route the request
    $routeInfo = $router->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            echo "404 Not Found";
            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(405);
            echo "405 Method Not Allowed";
            break;

        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            $monitor->checkpoint('route_found');

            // Call the handler
            if (is_callable($handler)) {
                $response = $handler($vars);
            } else {
                [$controller, $method] = explode('@', $handler);
                $controllerInstance = $serviceFactory->createController($controller);
                $response = $controllerInstance->$method($vars);
            }

            $monitor->checkpoint('response_generated');

            // Add performance headers in debug mode
            $config = $serviceFactory->createConfig();
            if ($config->isDebug()) {
                $monitor->addDebugHeader();
                $response .= $monitor->renderDebugInfo();
            }

            echo $response;
            break;
    }
} catch (Exception $e) {
    http_response_code(500);

    $config = $serviceFactory->createConfig() ?? null;
    if ($config && $config->isDebug()) {
        echo "<h1>Internal Server Error</h1>";
        echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
        echo $monitor->renderDebugInfo();
    } else {
        echo json_encode([
            'error' => 'Internal Server Error'
        ]);
    }
}
