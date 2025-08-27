<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Service;

/**
 * Query Bus Interface for CQRS pattern
 */
interface QueryBusInterface
{
    /**
     * Handle a query
     */
    public function handle(object $query): mixed;

    /**
     * Register a query handler
     */
    public function register(string $queryClass, callable $handler): void;
}
