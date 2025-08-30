<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Throwable;

/**
 * Centralized Logger for Boson PHP
 * 
 * Provides unified logging interface with multiple log levels and destinations
 */
class Logger
{
    public const EMERGENCY = 0;
    public const ALERT = 1;
    public const CRITICAL = 2;
    public const ERROR = 3;
    public const WARNING = 4;
    public const NOTICE = 5;
    public const INFO = 6;
    public const DEBUG = 7;

    /** @var array<int, string> */
    private static array $levelNames = [
        self::EMERGENCY => 'EMERGENCY',
        self::ALERT => 'ALERT',
        self::CRITICAL => 'CRITICAL',
        self::ERROR => 'ERROR',
        self::WARNING => 'WARNING',
        self::NOTICE => 'NOTICE',
        self::INFO => 'INFO',
        self::DEBUG => 'DEBUG',
    ];

    private string $logDirectory;
    private int $minLevel;
    private bool $enabled;

    public function __construct(
        ?string $logDirectory = null,
        int $minLevel = self::INFO,
        bool $enabled = true
    ) {
        $this->logDirectory = $logDirectory ?? PathManager::logs();
        $this->minLevel = $minLevel;
        $this->enabled = $enabled;
        
        // Ensure log directory exists
        PathManager::ensureDirectory($this->logDirectory);
    }

    /**
     * Log emergency message
     * @param array<string, mixed> $context
     */
    public function emergency(string $message, array $context = []): void
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Log alert message
     */
    public function alert(string $message, array $context = []): void
    {
        $this->log(self::ALERT, $message, $context);
    }

    /**
     * Log critical message
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Log error message
     */
    public function error(string $message, array $context = []): void
    {
        $this->log(self::ERROR, $message, $context);
    }

    /**
     * Log warning message
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log(self::WARNING, $message, $context);
    }

    /**
     * Log notice message
     */
    public function notice(string $message, array $context = []): void
    {
        $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Log info message
     */
    public function info(string $message, array $context = []): void
    {
        $this->log(self::INFO, $message, $context);
    }

    /**
     * Log debug message
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log(self::DEBUG, $message, $context);
    }

    /**
     * Log exception with full details
     */
    public function exception(Throwable $exception, int $level = self::ERROR): void
    {
        $message = sprintf(
            '%s: %s in %s:%d',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );

        $context = [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'previous' => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
        ];

        $this->log($level, $message, $context);
    }

    /**
     * Log message with specified level
     */
    public function log(int $level, string $message, array $context = []): void
    {
        if (!$this->enabled || $level > $this->minLevel) {
            return;
        }

        $logEntry = $this->formatLogEntry($level, $message, $context);
        $this->writeToFile($level, $logEntry);
        
        // Also send to PHP error log for critical errors
        if ($level <= self::ERROR) {
            error_log($logEntry);
        }
    }

    /**
     * Format log entry
     */
    private function formatLogEntry(int $level, string $message, array $context): string
    {
        $timestamp = date('Y-m-d H:i:s');
        $levelName = self::$levelNames[$level] ?? 'UNKNOWN';
        $pid = getmypid();
        $memory = $this->formatBytes(memory_get_usage(true));
        
        $logEntry = sprintf(
            "[%s] %s [PID:%d] [MEM:%s] %s",
            $timestamp,
            $levelName,
            $pid,
            $memory,
            $message
        );

        // Add context if provided
        if (!empty($context)) {
            $contextString = $this->formatContext($context);
            $logEntry .= " | Context: " . $contextString;
        }

        return $logEntry . PHP_EOL;
    }

    /**
     * Format context array
     */
    private function formatContext(array $context): string
    {
        $formatted = [];
        
        foreach ($context as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $formatted[] = "$key=" . var_export($value, true);
            } elseif (is_array($value)) {
                $formatted[] = "$key=" . json_encode($value, JSON_UNESCAPED_SLASHES);
            } else {
                $formatted[] = "$key=" . gettype($value);
            }
        }
        
        return implode(', ', $formatted);
    }

    /**
     * Write log entry to appropriate file
     */
    private function writeToFile(int $level, string $logEntry): void
    {
        try {
            $filename = $this->getLogFilename($level);
            $filepath = $this->logDirectory . '/' . $filename;
            
            file_put_contents($filepath, $logEntry, FILE_APPEND | LOCK_EX);
        } catch (Throwable $e) {
            // Fallback to PHP error log
            error_log("Logger failed to write to file: " . $e->getMessage());
            error_log($logEntry);
        }
    }

    /**
     * Get log filename based on level and date
     */
    private function getLogFilename(int $level): string
    {
        $date = date('Y-m-d');
        
        return match($level) {
            self::EMERGENCY, self::ALERT, self::CRITICAL => "critical-$date.log",
            self::ERROR => "error-$date.log",
            self::WARNING => "warning-$date.log",
            self::NOTICE, self::INFO => "info-$date.log",
            self::DEBUG => "debug-$date.log",
            default => "app-$date.log"
        };
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
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Get log statistics
     */
    public function getStats(): array
    {
        $stats = [
            'directory' => $this->logDirectory,
            'enabled' => $this->enabled,
            'min_level' => self::$levelNames[$this->minLevel] ?? 'UNKNOWN',
            'files' => [],
            'total_size' => 0,
        ];

        if (is_dir($this->logDirectory)) {
            $files = glob($this->logDirectory . '/*.log');
            
            foreach ($files as $file) {
                $size = filesize($file);
                $stats['files'][basename($file)] = [
                    'size' => $this->formatBytes($size),
                    'modified' => date('Y-m-d H:i:s', filemtime($file)),
                    'lines' => $this->countLines($file),
                ];
                $stats['total_size'] += $size;
            }
        }
        
        $stats['total_size'] = $this->formatBytes($stats['total_size']);
        
        return $stats;
    }

    /**
     * Count lines in log file
     */
    private function countLines(string $file): int
    {
        try {
            $lines = 0;
            $handle = fopen($file, 'r');
            
            if ($handle) {
                while (!feof($handle)) {
                    if (fgets($handle) !== false) {
                        $lines++;
                    }
                }
                fclose($handle);
            }
            
            return $lines;
        } catch (Throwable $e) {
            return 0;
        }
    }

    /**
     * Clear old log files
     */
    public function cleanup(int $daysToKeep = 30): int
    {
        $deleted = 0;
        $cutoffTime = time() - ($daysToKeep * 24 * 60 * 60);
        
        if (is_dir($this->logDirectory)) {
            $files = glob($this->logDirectory . '/*.log');
            
            foreach ($files as $file) {
                if (filemtime($file) < $cutoffTime) {
                    if (unlink($file)) {
                        $deleted++;
                    }
                }
            }
        }
        
        return $deleted;
    }
}
