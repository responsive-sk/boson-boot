<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Enhanced Container Interface with additional capabilities
 * Extends PSR-11 ContainerInterface for interoperability
 */
interface ContainerInterface extends PsrContainerInterface
{
    /**
     * Register a service with the container
     */
    public function set(string $id, mixed $service): void;

    /**
     * Register a factory for lazy service creation
     */
    public function factory(string $id, callable $factory): void;

    /**
     * Check if a service is registered
     */
    public function has(string $id): bool;

    /**
     * Get a service from the container
     */
    public function get(string $id): mixed;

    /**
     * Tag a service for later retrieval
     */
    public function tag(string $tag, string $serviceId): void;

    /**
     * Get all services with a specific tag
     */
    public function getTagged(string $tag): array;

    /**
     * Register a service provider
     */
    public function register(ServiceProviderInterface $provider): void;

    /**
     * Extend a service with a decorator
     */
    public function extend(string $id, callable $extender): void;

    /**
     * Get all registered service IDs
     */
    public function getServiceIds(): array;

    /**
     * Check if a service is shared (singleton)
     */
    public function isShared(string $id): bool;

    /**
     * Set a service as shared (singleton) or not
     */
    public function setShared(string $id, bool $shared): void;
}
