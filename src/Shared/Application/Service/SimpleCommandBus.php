<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Service;

/**
 * Simple Command Bus Implementation
 */
class SimpleCommandBus implements CommandBusInterface
{
    private array $handlers = [];

    public function handle(object $command): mixed
    {
        $commandClass = get_class($command);

        if (!isset($this->handlers[$commandClass])) {
            throw new \RuntimeException(
                sprintf('No handler registered for command: %s', $commandClass)
            );
        }

        $handler = $this->handlers[$commandClass];

        if (is_callable($handler)) {
            return $handler($command);
        }

        if (is_object($handler) && method_exists($handler, 'handle')) {
            return $handler->handle($command);
        }

        throw new \RuntimeException(
            sprintf('Invalid handler for command: %s', $commandClass)
        );
    }

    public function register(string $commandClass, callable $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * Register multiple handlers at once
     */
    public function registerHandlers(array $handlers): void
    {
        foreach ($handlers as $commandClass => $handler) {
            $this->register($commandClass, $handler);
        }
    }

    /**
     * Check if handler is registered for command
     */
    public function hasHandler(string $commandClass): bool
    {
        return isset($this->handlers[$commandClass]);
    }

    /**
     * Get all registered command classes
     */
    public function getRegisteredCommands(): array
    {
        return array_keys($this->handlers);
    }
}
