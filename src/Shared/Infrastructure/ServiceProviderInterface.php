<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

/**
 * Service Provider Interface for modular service registration
 */
interface ServiceProviderInterface
{
    /**
     * Register services with the container
     */
    public function register(ContainerInterface $container): void;

    /**
     * Boot services after all providers are registered
     */
    public function boot(ContainerInterface $container): void;

    /**
     * Get the services provided by this provider
     */
    public function provides(): array;

    /**
     * Get the priority of this provider (higher = earlier registration)
     */
    public function getPriority(): int;
}
