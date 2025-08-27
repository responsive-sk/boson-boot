<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Monitoring;

use function array_slice;
use function count;

class PerformanceMonitor
{
    private static ?self $instance = null;

    private float $startTime;

    private int $startMemory;

    private array $checkpoints = [];

    private array $queries = [];

    private function __construct()
    {
        $this->startTime   = microtime(true);
        $this->startMemory = memory_get_usage(true);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function checkpoint(string $name): void
    {
        $this->checkpoints[$name] = [
            'time'         => microtime(true),
            'memory'       => memory_get_usage(true),
            'elapsed'      => microtime(true) - $this->startTime,
            'memory_delta' => memory_get_usage(true) - $this->startMemory,
        ];
    }

    public function logQuery(string $sql, array $params = [], float $executionTime = 0): void
    {
        $this->queries[] = [
            'sql'            => $sql,
            'params'         => $params,
            'execution_time' => $executionTime,
            'timestamp'      => microtime(true),
        ];
    }

    public function getStats(): array
    {
        $currentTime   = microtime(true);
        $currentMemory = memory_get_usage(true);
        $peakMemory    = memory_get_peak_usage(true);

        return [
            'execution_time' => round(($currentTime - $this->startTime) * 1000, 2), // ms
            'memory_usage'   => [
                'current' => $this->formatBytes($currentMemory),
                'peak'    => $this->formatBytes($peakMemory),
                'delta'   => $this->formatBytes($currentMemory - $this->startMemory),
            ],
            'queries' => [
                'count'      => count($this->queries),
                'total_time' => round(array_sum(array_column($this->queries, 'execution_time')) * 1000, 2),
                'details'    => $this->queries,
            ],
            'checkpoints' => $this->checkpoints,
        ];
    }

    public function getExecutionTime(): float
    {
        return round((microtime(true) - $this->startTime) * 1000, 2);
    }

    public function getMemoryUsage(): array
    {
        return [
            'current' => memory_get_usage(true),
            'peak'    => memory_get_peak_usage(true),
            'delta'   => memory_get_usage(true) - $this->startMemory,
        ];
    }

    public function getQueryCount(): int
    {
        return count($this->queries);
    }

    public function getSlowestQueries(int $limit = 5): array
    {
        $queries = $this->queries;
        usort($queries, static function ($a, $b) {
            return $b['execution_time'] <=> $a['execution_time'];
        });

        return array_slice($queries, 0, $limit);
    }

    public function addDebugHeader(): void
    {
        if (!headers_sent()) {
            $stats = $this->getStats();
            header('X-Debug-Time: ' . $stats['execution_time'] . 'ms');
            header('X-Debug-Memory: ' . $stats['memory_usage']['current']);
            header('X-Debug-Queries: ' . $stats['queries']['count']);
        }
    }

    public function renderDebugInfo(): string
    {
        $stats = $this->getStats();

        $html = '<div id="debug-info" style="
            position: fixed;
            bottom: 0;
            right: 0;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 10px;
            font-family: monospace;
            font-size: 12px;
            z-index: 9999;
            max-width: 400px;
            border-radius: 5px 0 0 0;
        ">';

        $html .= '<strong>Performance Debug</strong><br>';
        $html .= 'Time: ' . $stats['execution_time'] . 'ms<br>';
        $html .= 'Memory: ' . $stats['memory_usage']['current'] . ' (Peak: ' . $stats['memory_usage']['peak'] . ')<br>';
        $html .= 'Queries: ' . $stats['queries']['count'] . ' (' . $stats['queries']['total_time'] . 'ms)<br>';

        if (!empty($this->checkpoints)) {
            $html .= '<br><strong>Checkpoints:</strong><br>';
            foreach ($this->checkpoints as $name => $data) {
                $html .= $name . ': ' . round($data['elapsed'] * 1000, 2) . 'ms<br>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    public static function start(): self
    {
        return self::getInstance();
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
