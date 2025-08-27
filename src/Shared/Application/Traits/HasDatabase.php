<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Traits;

use Boson\Shared\Infrastructure\Persistence\Database;
use Boson\Shared\Infrastructure\Config;

/**
 * Trait pre controllers čo potrebujú databázu
 */
trait HasDatabase
{
    protected Database $database;
    protected Config $config;

    public function setDatabase(Database $database): void
    {
        $this->database = $database;
    }

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    /**
     * Execute query s error handling
     */
    protected function query(string $sql, array $params = []): array
    {
        try {
            return $this->database->query($sql, $params);
        } catch (\Exception $e) {
            // Log error
            error_log("Database query failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single record
     */
    protected function queryOne(string $sql, array $params = []): ?array
    {
        $results = $this->query($sql, $params);
        return $results[0] ?? null;
    }

    /**
     * Execute statement
     */
    protected function execute(string $sql, array $params = []): bool
    {
        try {
            $this->database->execute($sql, $params);
            return true;
        } catch (\Exception $e) {
            error_log("Database execute failed: " . $e->getMessage());
            return false;
        }
    }
}
