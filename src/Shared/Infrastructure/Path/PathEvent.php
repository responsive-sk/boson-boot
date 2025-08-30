<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Path;

/**
 * Basic path event implementation
 */
class PathEvent implements PathEventInterface
{
    private string $name;
    private string $path;
    private array $params;
    private bool $propagationStopped = false;

    public function __construct(string $name, string $path, array $params = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    /**
     * Set a parameter
     */
    public function setParam(string $key, $value): void
    {
        $this->params[$key] = $value;
    }

    /**
     * Get a parameter with default value
     */
    public function getParam(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }
}
