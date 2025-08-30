<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Path;

/**
 * Interface for custom path resolvers
 */
interface PathResolverInterface
{
    /**
     * Check if this resolver can handle the given path pattern
     */
    public function supports(string $pattern): bool;

    /**
     * Resolve the path pattern to an actual path
     */
    public function resolve(string $pattern, array $context = []): string;

    /**
     * Get the priority of this resolver (higher = tried first)
     */
    public function getPriority(): int;
}
