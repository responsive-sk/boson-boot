<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Cache;

use PDO;
use PDOStatement;

class QueryCache
{
    private CacheInterface $cache;
    private PDO $pdo;
    private int $defaultTtl;

    public function __construct(PDO $pdo, CacheInterface $cache, int $defaultTtl = 3600)
    {
        $this->pdo = $pdo;
        $this->cache = $cache;
        $this->defaultTtl = $defaultTtl;
    }

    public function query(string $sql, array $params = [], int $ttl = null): array
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $cacheKey = $this->generateCacheKey($sql, $params);
        
        // Try to get from cache first
        $cached = $this->cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // Execute query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cache the result
        $this->cache->set($cacheKey, $result, $ttl);

        return $result;
    }

    public function queryOne(string $sql, array $params = [], int $ttl = null): ?array
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $cacheKey = $this->generateCacheKey($sql, $params) . ':one';
        
        // Try to get from cache first
        $cached = $this->cache->get($cacheKey);
        if ($cached !== null) {
            return $cached === false ? null : $cached;
        }

        // Execute query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cache the result (false for no result)
        $this->cache->set($cacheKey, $result ?: false, $ttl);

        return $result ?: null;
    }

    public function queryColumn(string $sql, array $params = [], int $ttl = null)
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $cacheKey = $this->generateCacheKey($sql, $params) . ':column';
        
        // Try to get from cache first
        $cached = $this->cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // Execute query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchColumn();

        // Cache the result
        $this->cache->set($cacheKey, $result, $ttl);

        return $result;
    }

    public function execute(string $sql, array $params = []): bool
    {
        // For write operations, invalidate related cache entries
        $this->invalidateByPattern($this->extractTableFromSql($sql));
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function invalidate(string $sql, array $params = []): void
    {
        $cacheKey = $this->generateCacheKey($sql, $params);
        $this->cache->delete($cacheKey);
        $this->cache->delete($cacheKey . ':one');
        $this->cache->delete($cacheKey . ':column');
    }

    public function invalidateByPattern(string $pattern): void
    {
        // This is a simple implementation - in production you might want
        // to use a more sophisticated cache invalidation strategy
        if (method_exists($this->cache, 'deleteByPattern')) {
            $this->cache->deleteByPattern($pattern);
        } else {
            // Fallback: clear all cache (not ideal but safe)
            $this->cache->clear();
        }
    }

    public function invalidateTable(string $table): void
    {
        $this->invalidateByPattern("table:{$table}:");
    }

    private function generateCacheKey(string $sql, array $params): string
    {
        $table = $this->extractTableFromSql($sql);
        $sqlHash = md5($sql);
        $paramsHash = md5(serialize($params));
        
        return "query:table:{$table}:{$sqlHash}:{$paramsHash}";
    }

    private function extractTableFromSql(string $sql): string
    {
        // Simple table extraction - can be improved
        $sql = strtolower(trim($sql));
        
        if (preg_match('/(?:from|into|update|join)\s+([a-zA-Z_][a-zA-Z0-9_]*)/i', $sql, $matches)) {
            return $matches[1];
        }
        
        return 'unknown';
    }

    public function getStats(): array
    {
        // Basic stats - can be extended
        return [
            'cache_enabled' => true,
            'default_ttl' => $this->defaultTtl
        ];
    }

    public function warmUp(array $queries): void
    {
        foreach ($queries as $query) {
            $sql = $query['sql'] ?? '';
            $params = $query['params'] ?? [];
            $ttl = $query['ttl'] ?? null;
            
            if (!empty($sql)) {
                $this->query($sql, $params, $ttl);
            }
        }
    }
}
