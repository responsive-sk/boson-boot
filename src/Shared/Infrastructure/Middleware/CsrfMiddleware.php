<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Middleware;

use Boson\Shared\Infrastructure\Security\CsrfProtection;

class CsrfMiddleware implements MiddlewareInterface
{
    private CsrfProtection $csrf;
    private array $excludedMethods;
    private array $excludedPaths;

    public function __construct(
        ?CsrfProtection $csrf = null,
        array $excludedMethods = ['GET', 'HEAD', 'OPTIONS'],
        array $excludedPaths = []
    ) {
        $this->csrf = $csrf ?? new CsrfProtection();
        $this->excludedMethods = $excludedMethods;
        $this->excludedPaths = $excludedPaths;
    }

    public function handle(array $request, callable $next): array
    {
        $method = $request['method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $request['path'] ?? $_SERVER['REQUEST_URI'] ?? '/';

        // Skip CSRF check for excluded methods
        if (in_array($method, $this->excludedMethods)) {
            return $next($request);
        }

        // Skip CSRF check for excluded paths
        foreach ($this->excludedPaths as $excludedPath) {
            if (strpos($path, $excludedPath) === 0) {
                return $next($request);
            }
        }

        // Validate CSRF token
        if (!$this->csrf->validateRequest()) {
            http_response_code(403);
            header('Content-Type: application/json');
            
            $request['response'] = json_encode([
                'error' => 'CSRF Token Mismatch',
                'message' => 'Invalid or missing CSRF token.'
            ]);
            
            $request['stop_execution'] = true;
            return $request;
        }

        return $next($request);
    }

    public function addExcludedPath(string $path): void
    {
        $this->excludedPaths[] = $path;
    }

    public function addExcludedMethod(string $method): void
    {
        $this->excludedMethods[] = strtoupper($method);
    }
}
