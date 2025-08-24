<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

class Config
{
    private static ?self $instance = null;
    private array $config = [];
    private bool $loaded = false;

    private function __construct()
    {
        $this->loadEnvironment();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadEnvironment(): void
    {
        if ($this->loaded) {
            return;
        }

        $envFile = __DIR__ . '/../../../.env';
        if (!file_exists($envFile)) {
            throw new \RuntimeException('.env file not found. Copy .env.example to .env and configure it.');
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }

            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                
                // Handle base64 encoded values
                if (strpos($value, 'base64:') === 0) {
                    $value = base64_decode(substr($value, 7));
                }
                
                $this->config[$key] = $value;
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }

        $this->loaded = true;
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    public function all(): array
    {
        return $this->config;
    }

    // Convenience methods for common config values
    public function isDebug(): bool
    {
        return $this->get('APP_DEBUG', 'false') === 'true';
    }

    public function getAppName(): string
    {
        return $this->get('APP_NAME', 'Boson PHP');
    }

    public function getAppUrl(): string
    {
        return $this->get('APP_URL', 'http://localhost:8080');
    }

    public function getDbPath(): string
    {
        $path = $this->get('DB_DATABASE', './database/blog.sqlite');
        // Convert relative path to absolute path
        if (strpos($path, './') === 0) {
            $path = __DIR__ . '/../../../' . substr($path, 2);
        }
        return $path;
    }

    public function getBlogPostsPerPage(): int
    {
        return (int) $this->get('BLOG_POSTS_PER_PAGE', 10);
    }

    public function getBlogExcerptLength(): int
    {
        return (int) $this->get('BLOG_EXCERPT_LENGTH', 150);
    }

    public function getUploadPath(): string
    {
        return $this->get('UPLOAD_PATH', './public/uploads');
    }

    public function getUploadMaxSize(): int
    {
        return (int) $this->get('UPLOAD_MAX_SIZE', 10485760);
    }

    public function getUploadAllowedTypes(): array
    {
        $types = $this->get('UPLOAD_ALLOWED_TYPES', 'jpg,jpeg,png,gif,webp');
        return explode(',', $types);
    }

    public function getSearchMinLength(): int
    {
        return (int) $this->get('SEARCH_MIN_LENGTH', 2);
    }

    public function getSearchMaxResults(): int
    {
        return (int) $this->get('SEARCH_MAX_RESULTS', 50);
    }
}
