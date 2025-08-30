<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Service;

/**
 * Command Bus Interface for CQRS pattern
 */
interface CommandBusInterface
{
    /**
     * Handle a command
     */
    public function handle(object $command): mixed;

    /**
     * Register a command handler
     */
    public function register(string $commandClass, callable $handler): void;
}
