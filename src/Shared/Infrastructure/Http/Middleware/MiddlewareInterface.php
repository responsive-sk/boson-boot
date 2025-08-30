<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

interface MiddlewareInterface
{
    public function handle(array $request, callable $next): array;
}
