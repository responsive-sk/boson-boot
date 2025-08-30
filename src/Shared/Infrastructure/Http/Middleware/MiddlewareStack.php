<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

use function count;

class MiddlewareStack
{
    private array $stack = [];

    public function add(MiddlewareInterface $middleware): void
    {
        $this->stack[] = $middleware;
    }

    public function handle(array $request): array
    {
        // Create a closure that processes middleware in proper order
        $next = function ($request) {
            return $request; // Final handler - just return the request
        };

        // Process through middleware in reverse order
        // This ensures first added middleware executes first
        for ($i = count($this->stack) - 1; $i >= 0; $i--) {
            $middleware = $this->stack[$i];
            $next = function ($request) use ($middleware, $next) {
                return $middleware->handle($request, $next);
            };
        }

        return $next($request);
    }

    public function getMiddleware(): array
    {
        return $this->stack;
    }

    public function clear(): void
    {
        $this->stack = [];
    }

    public function count(): int
    {
        return count($this->stack);
    }
}
