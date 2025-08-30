<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

use Boson\Shared\Infrastructure\Security\CsrfProtection;

use function in_array;

class CsrfMiddleware implements MiddlewareInterface
{
    private CsrfProtection $csrf;

    private array $excludedMethods;

    private array $excludedPaths;

    public function __construct(
        ?CsrfProtection $csrf = null,
        array $excludedMethods = ['GET', 'HEAD', 'OPTIONS'],
        array $excludedPaths = [],
    ) {
        $this->csrf            = $csrf ?? new CsrfProtection();
        $this->excludedMethods = $excludedMethods;
        $this->excludedPaths   = $excludedPaths;
    }

    public function handle(array $request, callable $next): array
    {
        $method = $request['method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Skip CSRF check for excluded methods
        if (in_array($method, $this->excludedMethods, true)) {
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

            // Check if it's an HTMX request
            $isHtmx = !empty($request['headers']['Hx-Request'] ?? $_SERVER['HTTP_HX_REQUEST'] ?? '');

            if ($isHtmx) {
                // Return HTMX-friendly error
                $request['response'] = '<div class="alert alert-danger">CSRF token mismatch. Please refresh the page.</div>';
            } else {
                // Return JSON error
                header('Content-Type: application/json');
                $request['response'] = json_encode([
                    'error' => 'CSRF Token Mismatch',
                    'message' => 'Invalid or missing CSRF token. Please refresh the page.',
                ]);
            }

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
