<?php

declare(strict_types=1);

/**
 * PSR-15 Middleware Demo
 *
 * This file demonstrates how to use the PSR-15 middleware implementation
 * in the Boson framework.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Http\Kernel;
use Boson\Shared\Infrastructure\Http\Psr15\Middleware\Psr15LoggingMiddleware;
use Boson\Shared\Infrastructure\Http\Psr15\PsrRequestAdapter;
use Boson\Shared\Infrastructure\Http\Psr15\PsrResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

// Example PSR-15 middleware
class ExamplePsr15Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Add custom header to demonstrate middleware processing
        $response = $handler->handle($request);
        return $response->withHeader('X-Custom-Middleware', 'Processed');
    }
}

// Create kernel instance
$kernel = new Kernel();

// Enable PSR-15 mode
$kernel->enablePsr15Mode();

// Add PSR-15 middlewares
$kernel->addPsr15Middleware(new ExamplePsr15Middleware());

// You can also add custom middlewares - they will be automatically wrapped
// $kernel->addMiddleware(new CustomMiddleware());

// Create a PSR-7 request for testing
$arrayRequest = [
    'method' => 'GET',
    'uri' => '/api/test',
    'server' => ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/api/test'],
    'get' => ['param' => 'value'],
    'post' => [],
    'headers' => ['Content-Type' => 'application/json'],
    'attributes' => [],
];

$psrRequest = new PsrRequestAdapter($arrayRequest);

// Handle the request
try {
    $psrResponse = $kernel->handlePsr7($psrRequest);

    echo "PSR-15 Demo Results:\n";
    echo "====================\n";
    echo "Status Code: " . $psrResponse->getStatusCode() . "\n";
    echo "Headers:\n";
    foreach ($psrResponse->getHeaders() as $name => $values) {
        echo "  $name: " . implode(', ', $values) . "\n";
    }
    echo "Body: " . $psrResponse->getBody()->getContents() . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// You can also handle array-based requests
echo "\nArray-based Request Demo:\n";
echo "=========================\n";

$arrayResponse = $kernel->handleArray($arrayRequest);
echo "Status: " . ($arrayResponse['status'] ?? 'unknown') . "\n";
echo "Headers: " . json_encode($arrayResponse['headers'] ?? []) . "\n";
echo "Body: " . ($arrayResponse['body'] ?? '') . "\n";

echo "\nPSR-15 integration completed successfully!\n";
