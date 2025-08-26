<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Cache;

interface CacheInterface
{
    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value, int $ttl = 3600): bool;

    public function delete(string $key): bool;

    public function clear(): bool;

    public function has(string $key): bool;

    /**
     * @param array<string> $keys
     *
     * @return array<string, mixed>
     */
    public function getMultiple(array $keys, mixed $default = null): array;

    /**
     * @param array<string, mixed> $values
     */
    public function setMultiple(array $values, int $ttl = 3600): bool;

    /**
     * @param array<string> $keys
     */
    public function deleteMultiple(array $keys): bool;
}
