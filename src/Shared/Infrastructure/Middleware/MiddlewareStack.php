<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Middleware;

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
        $runner = new class($this->stack) {
            private array $stack;

            private int $index = 0;

            public function __construct(array $stack)
            {
                $this->stack = $stack;
            }

            public function __invoke(array $request): array
            {
                if (!isset($this->stack[$this->index])) {
                    return $request;
                }

                $middleware = $this->stack[$this->index];
                ++$this->index;

                return $middleware->handle($request, $this);
            }
        };

        return $runner($request);
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
