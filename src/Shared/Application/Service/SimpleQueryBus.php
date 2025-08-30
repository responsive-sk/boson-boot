<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Service;

/**
 * Simple Query Bus Implementation
 */
class SimpleQueryBus implements QueryBusInterface
{
    private array $handlers = [];

    public function handle(object $query): mixed
    {
        $queryClass = get_class($query);

        if (!isset($this->handlers[$queryClass])) {
            throw new \RuntimeException(
                sprintf('No handler registered for query: %s', $queryClass)
            );
        }

        $handler = $this->handlers[$queryClass];

        if (is_callable($handler)) {
            return $handler($query);
        }

        if (is_object($handler) && method_exists($handler, 'handle')) {
            return $handler->handle($query);
        }

        throw new \RuntimeException(
            sprintf('Invalid handler for query: %s', $queryClass)
        );
    }

    public function register(string $queryClass, callable $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    /**
     * Register multiple handlers at once
     */
    public function registerHandlers(array $handlers): void
    {
        foreach ($handlers as $queryClass => $handler) {
            $this->register($queryClass, $handler);
        }
    }

    /**
     * Check if handler is registered for query
     */
    public function hasHandler(string $queryClass): bool
    {
        return isset($this->handlers[$queryClass]);
    }

    /**
     * Get all registered query classes
     */
    public function getRegisteredQueries(): array
    {
        return array_keys($this->handlers);
    }
}
