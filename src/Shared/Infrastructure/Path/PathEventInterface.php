<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Path;

/**
 * Interface for path events
 */
interface PathEventInterface
{
    /**
     * Get the event name
     */
    public function getName(): string;

    /**
     * Get the path associated with the event
     */
    public function getPath(): string;

    /**
     * Get additional event parameters
     */
    public function getParams(): array;

    /**
     * Check if the event propagation is stopped
     */
    public function isPropagationStopped(): bool;

    /**
     * Stop event propagation
     */
    public function stopPropagation(): void;
}
