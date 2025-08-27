<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Middleware;

use Boson\Shared\Infrastructure\ServiceFactory;
use Boson\Shared\Infrastructure\RequestHandler;
use Boson\Shared\Infrastructure\Performance\PerformanceMonitor;

class RequestHandlerMiddleware implements MiddlewareInterface
{
    private ServiceFactory $serviceFactory;

    public function __construct(ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
    }

    public function handle(array $request, callable $next): array
    {
        // Extract HTTP method and URI from request
        $httpMethod = $request['method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'] ?? '/';

        // Remove query string and decode
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        // Create request handler with performance monitoring
        $monitor = PerformanceMonitor::getInstance();
        $requestHandler = new RequestHandler($this->serviceFactory, $monitor);
        
        // Handle the request
        $response = $requestHandler->handle($httpMethod, $uri);
        
        // Store response in request array
        $request['response'] = $response;
        $request['handled'] = true;
        
        return $request;
    }
}
