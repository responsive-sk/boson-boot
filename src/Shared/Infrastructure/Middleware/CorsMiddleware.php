<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Middleware;

/**
 * CORS (Cross-Origin Resource Sharing) Middleware
 */
class CorsMiddleware implements MiddlewareInterface
{
    private array $allowedOrigins;
    private array $allowedMethods;
    private array $allowedHeaders;
    private array $exposedHeaders;
    private bool $allowCredentials;
    private int $maxAge;

    public function __construct(
        array $allowedOrigins = ['*'],
        array $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        array $allowedHeaders = ['Content-Type', 'Authorization', 'X-Requested-With'],
        array $exposedHeaders = [],
        bool $allowCredentials = false,
        int $maxAge = 86400
    ) {
        $this->allowedOrigins = $allowedOrigins;
        $this->allowedMethods = $allowedMethods;
        $this->allowedHeaders = $allowedHeaders;
        $this->exposedHeaders = $exposedHeaders;
        $this->allowCredentials = $allowCredentials;
        $this->maxAge = $maxAge;
    }

    public function handle(array $request, callable $next): array
    {
        $origin = $request['headers']['Origin'] ?? $_SERVER['HTTP_ORIGIN'] ?? null;
        $method = $request['method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Set CORS headers
        $this->setCorsHeaders($origin);

        // Handle preflight OPTIONS request
        if ($method === 'OPTIONS') {
            http_response_code(200);
            $request['response'] = '';
            $request['stop_execution'] = true;
            return $request;
        }

        // Continue with normal request processing
        return $next($request);
    }

    /**
     * Set CORS headers
     */
    private function setCorsHeaders(?string $origin): void
    {
        if (!headers_sent()) {
            // Access-Control-Allow-Origin
            if ($this->isOriginAllowed($origin)) {
                header('Access-Control-Allow-Origin: ' . ($origin ?? '*'));
            }

            // Access-Control-Allow-Methods
            if (!empty($this->allowedMethods)) {
                header('Access-Control-Allow-Methods: ' . implode(', ', $this->allowedMethods));
            }

            // Access-Control-Allow-Headers
            if (!empty($this->allowedHeaders)) {
                header('Access-Control-Allow-Headers: ' . implode(', ', $this->allowedHeaders));
            }

            // Access-Control-Expose-Headers
            if (!empty($this->exposedHeaders)) {
                header('Access-Control-Expose-Headers: ' . implode(', ', $this->exposedHeaders));
            }

            // Access-Control-Allow-Credentials
            if ($this->allowCredentials) {
                header('Access-Control-Allow-Credentials: true');
            }

            // Access-Control-Max-Age
            if ($this->maxAge > 0) {
                header('Access-Control-Max-Age: ' . $this->maxAge);
            }
        }
    }

    /**
     * Check if origin is allowed
     */
    private function isOriginAllowed(?string $origin): bool
    {
        if (!$origin) {
            return true; // No origin header, allow
        }

        if (in_array('*', $this->allowedOrigins, true)) {
            return true; // Wildcard allows all
        }

        return in_array($origin, $this->allowedOrigins, true);
    }

    /**
     * Add allowed origin
     */
    public function addAllowedOrigin(string $origin): self
    {
        if (!in_array($origin, $this->allowedOrigins, true)) {
            $this->allowedOrigins[] = $origin;
        }
        return $this;
    }

    /**
     * Add allowed method
     */
    public function addAllowedMethod(string $method): self
    {
        $method = strtoupper($method);
        if (!in_array($method, $this->allowedMethods, true)) {
            $this->allowedMethods[] = $method;
        }
        return $this;
    }

    /**
     * Add allowed header
     */
    public function addAllowedHeader(string $header): self
    {
        if (!in_array($header, $this->allowedHeaders, true)) {
            $this->allowedHeaders[] = $header;
        }
        return $this;
    }

    /**
     * Add exposed header
     */
    public function addExposedHeader(string $header): self
    {
        if (!in_array($header, $this->exposedHeaders, true)) {
            $this->exposedHeaders[] = $header;
        }
        return $this;
    }

    /**
     * Set credentials support
     */
    public function setAllowCredentials(bool $allow): self
    {
        $this->allowCredentials = $allow;
        return $this;
    }

    /**
     * Set max age for preflight cache
     */
    public function setMaxAge(int $maxAge): self
    {
        $this->maxAge = $maxAge;
        return $this;
    }

    /**
     * Create middleware for API endpoints
     */
    public static function forApi(): self
    {
        return new self(
            allowedOrigins: ['*'],
            allowedMethods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
            allowedHeaders: [
                'Content-Type',
                'Authorization',
                'X-Requested-With',
                'Accept',
                'Origin',
                'X-CSRF-Token'
            ],
            exposedHeaders: ['X-Total-Count', 'X-Page-Count'],
            allowCredentials: true,
            maxAge: 3600
        );
    }

    /**
     * Create restrictive middleware for production
     */
    public static function forProduction(array $allowedOrigins): self
    {
        return new self(
            allowedOrigins: $allowedOrigins,
            allowedMethods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization', 'X-CSRF-Token'],
            allowCredentials: true,
            maxAge: 86400
        );
    }
}
