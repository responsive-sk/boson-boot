<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use FastRoute\Dispatcher;
use Boson\Shared\Infrastructure\Middleware\MiddlewareInterface;
use Boson\Shared\Infrastructure\Middleware\MiddlewareStack;

class RouterWithMiddleware extends Router
{
    private MiddlewareStack $middlewareStack;
    private array $routeMiddleware = [];

    public function __construct()
    {
        parent::__construct();
        $this->middlewareStack = new MiddlewareStack();
    }

    public function addGlobalMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middlewareStack->add($middleware);
    }

    public function addRouteMiddleware(string $pattern, MiddlewareInterface $middleware): void
    {
        if (!isset($this->routeMiddleware[$pattern])) {
            $this->routeMiddleware[$pattern] = new MiddlewareStack();
        }
        $this->routeMiddleware[$pattern]->add($middleware);
    }

    public function dispatch(string $httpMethod, string $uri): array
    {
        // Create request array
        $request = [
            'method' => $httpMethod,
            'uri' => $uri,
            'path' => parse_url($uri, PHP_URL_PATH),
            'query' => $_GET,
            'post' => $_POST,
            'server' => $_SERVER,
            'stop_execution' => false,
            'response' => null
        ];

        // Process through global middleware
        $processedRequest = $this->middlewareStack->handle($request);

        // Check if middleware stopped execution
        if ($processedRequest['stop_execution'] ?? false) {
            return [
                Dispatcher::FOUND,
                function() use ($processedRequest) {
                    return $processedRequest['response'] ?? '';
                },
                []
            ];
        }

        // Get route info
        $routeInfo = parent::dispatch($httpMethod, $uri);
        
        if ($routeInfo[0] !== Dispatcher::FOUND) {
            return $routeInfo;
        }

        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Process through route-specific middleware
        $routeMiddleware = $this->getRouteMiddleware($processedRequest['path']);
        if ($routeMiddleware) {
            $processedRequest['handler'] = $handler;
            $processedRequest['vars'] = $vars;
            
            $processedRequest = $routeMiddleware->handle($processedRequest);
            
            // Check if route middleware stopped execution
            if ($processedRequest['stop_execution'] ?? false) {
                return [
                    Dispatcher::FOUND,
                    function() use ($processedRequest) {
                        return $processedRequest['response'] ?? '';
                    },
                    []
                ];
            }
            
            $handler = $processedRequest['handler'];
            $vars = $processedRequest['vars'];
        }

        return [
            Dispatcher::FOUND,
            $handler,
            $vars
        ];
    }

    private function getRouteMiddleware(string $path): ?MiddlewareStack
    {
        foreach ($this->routeMiddleware as $pattern => $middleware) {
            if ($this->matchesPattern($path, $pattern)) {
                return $middleware;
            }
        }
        
        return null;
    }

    private function matchesPattern(string $path, string $pattern): bool
    {
        // Simple pattern matching - can be enhanced
        if ($pattern === '*') {
            return true;
        }
        
        if (strpos($pattern, '*') !== false) {
            $regex = str_replace('*', '.*', preg_quote($pattern, '/'));
            return preg_match("/^{$regex}$/", $path);
        }
        
        return $path === $pattern || strpos($path, $pattern) === 0;
    }

    public function getMiddlewareStats(): array
    {
        return [
            'global_middleware' => $this->middlewareStack->count(),
            'route_middleware' => count($this->routeMiddleware),
            'total_route_middleware' => array_sum(array_map(
                fn($stack) => $stack->count(),
                $this->routeMiddleware
            ))
        ];
    }
}
