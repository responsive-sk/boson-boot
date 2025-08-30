<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareInterface;
use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareStack;
use FastRoute\Dispatcher;

use function count;

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
        // Create complete request array
        $request = $this->createRequest($httpMethod, $uri);

        // Process through global middleware FIRST
        $processedRequest = $this->middlewareStack->handle($request);

        // If middleware stopped execution, return the response directly
        if ($processedRequest['stop_execution'] ?? false) {
            return [
                Dispatcher::FOUND,
                $this->createResponseHandler($processedRequest),
                []
            ];
        }

        // Get route info from parent router (standard FastRoute dispatch)
        $routeInfo = parent::dispatch($httpMethod, $uri);

        // If route not found, return early
        if ($routeInfo[0] !== Dispatcher::FOUND) {
            return $routeInfo;
        }

        // Extract handler and variables
        [$_, $handler, $vars] = $routeInfo;

        // Process through route-specific middleware if exists
        $routeMiddleware = $this->getRouteMiddleware($request['path']);
        if ($routeMiddleware) {
            $middlewareRequest = array_merge($processedRequest, [
                'handler' => $handler,
                'vars' => $vars
            ]);

            $middlewareResponse = $routeMiddleware->handle($middlewareRequest);

            // If route middleware stopped execution, return its response
            if ($middlewareResponse['stop_execution'] ?? false) {
                return [
                    Dispatcher::FOUND,
                    $this->createResponseHandler($middlewareResponse),
                    []
                ];
            }

            // Update handler and vars from middleware if modified
            $handler = $middlewareResponse['handler'] ?? $handler;
            $vars = $middlewareResponse['vars'] ?? $vars;
        }

        return [
            Dispatcher::FOUND,
            $handler,
            $vars
        ];
    }

    /**
     * Create complete request array with all necessary data
     */
    private function createRequest(string $httpMethod, string $uri): array
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        
        return [
            'method' => $httpMethod,
            'uri' => $uri,
            'path' => $path,
            'query' => $_GET,
            'post' => $_POST,
            'cookies' => $_COOKIE,
            'server' => $_SERVER,
            'headers' => $this->getRequestHeaders(),
            'files' => $_FILES,
            'session' => $_SESSION ?? [],
            'timestamp' => microtime(true),
            'ip' => $this->getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'is_secure' => $this->isSecureRequest(),
            'stop_execution' => false,
            'response' => null
        ];
    }

    /**
     * Create a response handler from middleware response
     */
    private function createResponseHandler(array $response): callable
    {
        return function () use ($response) {
            // Set HTTP status code if provided
            if (isset($response['status'])) {
                http_response_code($response['status']);
            }

            // Set headers if provided (with validation)
            if (isset($response['headers']) && is_array($response['headers'])) {
                $this->sendHeaders($response['headers']);
            }

            // Return the response body
            return $response['response'] ?? '';
        };
    }

    /**
     * Safely send headers with validation
     */
    private function sendHeaders(array $headers): void
    {
        if (headers_sent()) {
            return;
        }

        foreach ($headers as $header) {
            if (is_array($header) && isset($header['name'], $header['value'])) {
                // Validate header name
                $name = preg_replace('/[^\x20-\x7E]/', '', (string)$header['name']);
                $value = preg_replace('/[^\x20-\x7E]/', '', (string)$header['value']);
                
                if ($name && preg_match('/^[a-zA-Z0-9\-]+$/', $name)) {
                    header("{$name}: {$value}");
                }
            } elseif (is_string($header) && strpos($header, ':') !== false) {
                // Validate string header format
                [$name, $value] = explode(':', $header, 2);
                $name = trim($name);
                $value = trim($value);
                
                if (preg_match('/^[a-zA-Z0-9\-]+$/', $name)) {
                    header("{$name}: {$value}");
                }
            }
        }
    }

    /**
     * Get request headers from server variables
     */
    private function getRequestHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[$header] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'])) {
                $headers[str_replace('_', '-', $key)] = $value;
            }
        }
        return $headers;
    }

    /**
     * Get client IP address
     */
    private function getClientIp(): string
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = trim(explode(',', $_SERVER[$key])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Check if request is secure
     */
    private function isSecureRequest(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
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
        if ($pattern === '*') {
            return true;
        }

        if (strpos($pattern, '*') !== false) {
            $regex = str_replace('*', '.*', preg_quote($pattern, '/'));
            return preg_match("/^{$regex}$/", $path) === 1;
        }

        return $path === $pattern;
    }

    public function getMiddlewareStats(): array
    {
        return [
            'global_middleware' => $this->middlewareStack->count(),
            'route_middleware' => count($this->routeMiddleware),
            'total_route_middleware' => array_sum(array_map(
                static fn ($stack) => $stack->count(),
                $this->routeMiddleware
            )),
        ];
    }
}