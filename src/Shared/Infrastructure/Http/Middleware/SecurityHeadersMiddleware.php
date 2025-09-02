<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

class SecurityHeadersMiddleware implements MiddlewareInterface
{
    private array $headers;

    public function __construct(array $headers = [])
    {
        $this->headers = array_merge([
            'X-Content-Type-Options'            => 'nosniff',
            'X-Frame-Options'                   => 'DENY',
            'X-XSS-Protection'                  => '1; mode=block',
            'Referrer-Policy'                   => 'strict-origin-when-cross-origin',
            'X-Permitted-Cross-Domain-Policies' => 'none',
        ], $headers);
    }

    public function handle(array $request, callable $next): array
    {
        // Add security headers to request for later processing
        if (!isset($request['headers'])) {
            $request['headers'] = [];
        }

        foreach ($this->headers as $name => $value) {
            $request['headers'][] = "{$name}: {$value}";
        }

        return $next($request);
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function removeHeader(string $name): void
    {
        unset($this->headers[$name]);
    }
}
