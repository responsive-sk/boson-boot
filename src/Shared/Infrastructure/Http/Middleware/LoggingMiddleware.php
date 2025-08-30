<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

use Boson\Shared\Infrastructure\Monitoring\PerformanceMonitor;

/**
 * Middleware pre logovanie requestov a performance metrík
 */
class LoggingMiddleware implements MiddlewareInterface
{
    private string $logFile;
    private bool $logPerformance;
    private bool $logRequests;

    public function __construct(
        ?string $logFile = null,
        bool $logPerformance = true,
        bool $logRequests = true
    ) {
        $this->logFile = $logFile ?? $this->getDefaultLogFile();
        $this->logPerformance = $logPerformance;
        $this->logRequests = $logRequests;
    }

    public function handle(array $request, callable $next): array
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        // Log incoming request
        if ($this->logRequests) {
            $this->logRequest($request);
        }

        // Process request
        $response = $next($request);

        // Log performance metrics
        if ($this->logPerformance) {
            $this->logPerformance($request, $startTime, $startMemory);
        }

        return $response;
    }

    /**
     * Log incoming request
     */
    private function logRequest(array $request): void
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $request['method'] ?? 'GET',
            'uri' => $request['uri'] ?? '/',
            'ip' => $request['ip'] ?? $this->getClientIp(),
            'user_agent' => $request['headers']['User-Agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'referer' => $request['headers']['Referer'] ?? $_SERVER['HTTP_REFERER'] ?? null,
        ];

        $logLine = sprintf(
            "[%s] %s %s - IP: %s - UA: %s\n",
            $logData['timestamp'],
            $logData['method'],
            $logData['uri'],
            $logData['ip'],
            substr($logData['user_agent'], 0, 100)
        );

        $this->writeLog($logLine);
    }

    /**
     * Log performance metrics
     */
    private function logPerformance(array $request, float $startTime, int $startMemory): void
    {
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);
        $memoryUsage = memory_get_usage(true) - $startMemory;
        $peakMemory = memory_get_peak_usage(true);

        // Get performance monitor stats if available
        $monitor = PerformanceMonitor::getInstance();
        $stats = $monitor->getStats();

        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'uri' => $request['uri'] ?? '/',
            'execution_time' => $executionTime,
            'memory_usage' => $this->formatBytes($memoryUsage),
            'peak_memory' => $this->formatBytes($peakMemory),
            'query_count' => $stats['queries']['count'] ?? 0,
            'query_time' => $stats['queries']['total_time'] ?? 0,
        ];

        $logLine = sprintf(
            "[%s] PERF %s - Time: %sms - Memory: %s (Peak: %s) - Queries: %d (%sms)\n",
            $logData['timestamp'],
            $logData['uri'],
            $logData['execution_time'],
            $logData['memory_usage'],
            $logData['peak_memory'],
            $logData['query_count'],
            $logData['query_time']
        );

        $this->writeLog($logLine);
    }

    /**
     * Write log entry to file
     */
    private function writeLog(string $logLine): void
    {
        try {
            // Ensure log directory exists
            $logDir = dirname($this->logFile);
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }

            // Write log entry
            file_put_contents($this->logFile, $logLine, FILE_APPEND | LOCK_EX);
        } catch (\Exception $e) {
            // Fallback to error_log if file writing fails
            error_log("Logging middleware failed: " . $e->getMessage());
            error_log($logLine);
        }
    }

    /**
     * Get default log file path
     */
    private function getDefaultLogFile(): string
    {
        // Use PathManager for correct path resolution
        return \Boson\Shared\Infrastructure\PathManager::logs('app-' . date('Y-m-d') . '.log');
    }

    /**
     * Get client IP address
     */
    private function getClientIp(): string
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = trim(explode(',', $_SERVER[$key])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Set custom log file
     */
    public function setLogFile(string $logFile): self
    {
        $this->logFile = $logFile;
        return $this;
    }

    /**
     * Enable/disable performance logging
     */
    public function setPerformanceLogging(bool $enabled): self
    {
        $this->logPerformance = $enabled;
        return $this;
    }

    /**
     * Enable/disable request logging
     */
    public function setRequestLogging(bool $enabled): self
    {
        $this->logRequests = $enabled;
        return $this;
    }
}
