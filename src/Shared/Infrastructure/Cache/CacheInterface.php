<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Cache;

interface CacheInterface
{
    public function get(string $key, $default = null);
    
    public function set(string $key, $value, int $ttl = 3600): bool;
    
    public function delete(string $key): bool;
    
    public function clear(): bool;
    
    public function has(string $key): bool;
    
    public function getMultiple(array $keys, $default = null): array;
    
    public function setMultiple(array $values, int $ttl = 3600): bool;
    
    public function deleteMultiple(array $keys): bool;
}
