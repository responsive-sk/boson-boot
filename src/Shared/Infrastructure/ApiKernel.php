<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Shared\Infrastructure\Middleware\CorsMiddleware;
use Boson\Shared\Infrastructure\Middleware\JsonMiddleware;
use Boson\Shared\Infrastructure\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Middleware\RequestHandlerMiddleware;
use Boson\Shared\Infrastructure\Middleware\LoggingMiddleware;

/**
 * Specialized Kernel for API applications
 */
class ApiKernel extends Kernel
{
    private array $corsOrigins;
    private bool $enableLogging;

    public function __construct(array $corsOrigins = ['*'], bool $enableLogging = true)
    {
        parent::__construct();
        $this->corsOrigins = $corsOrigins;
        $this->enableLogging = $enableLogging;
    }

    /**
     * API-specific middleware stack
     */
    protected function initializeMiddleware(): void
    {
        // CORS must be first for preflight requests
        $this->middlewareStack->add(CorsMiddleware::forApi());
        
        // Security headers for API
        $this->middlewareStack->add(new SecurityHeadersMiddleware([
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'X-API-Version' => '1.0',
        ]));

        // Logging for API requests
        if ($this->enableLogging) {
            $this->middlewareStack->add(new LoggingMiddleware(
                logFile: $this->getApiLogFile(),
                logPerformance: true,
                logRequests: true
            ));
        }

        // JSON response handling
        $this->middlewareStack->add(JsonMiddleware::forApiOnly());

        // Rate limiting for API
        $this->middlewareStack->add(new RateLimitMiddleware(
            maxAttempts: 60,    // 60 requests
            windowSeconds: 60   // per minute
        ));

        // Request handling
        $this->middlewareStack->add(new RequestHandlerMiddleware($this->serviceFactory));
    }

    /**
     * API-specific request creation with additional headers
     */
    protected function createRequest(): array
    {
        $request = parent::createRequest();

        // Add API-specific data
        $request['is_api'] = true;
        $request['api_version'] = $this->getApiVersion();
        $request['content_type'] = $_SERVER['CONTENT_TYPE'] ?? 'application/json';

        // Parse JSON body for POST/PUT requests
        if (in_array($request['method'], ['POST', 'PUT', 'PATCH'])) {
            $request['json'] = $this->parseJsonBody();
        }

        return $request;
    }

    /**
     * Parse JSON request body
     */
    private function parseJsonBody(): ?array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            if ($input) {
                $decoded = json_decode($input, true);
                return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            }
        }

        return null;
    }

    /**
     * Get API version from headers or default
     */
    private function getApiVersion(): string
    {
        return $_SERVER['HTTP_X_API_VERSION'] ?? $_SERVER['HTTP_ACCEPT_VERSION'] ?? '1.0';
    }

    /**
     * Get API-specific log file
     */
    private function getApiLogFile(): string
    {
        $logDir = dirname(__DIR__, 3) . '/storage/logs';
        return $logDir . '/api-' . date('Y-m-d') . '.log';
    }

    /**
     * Override error handling for API responses
     */
    protected function handleException(\Exception $e): void
    {
        http_response_code(500);
        header('Content-Type: application/json');

        $config = $this->serviceFactory->createConfig();
        
        if ($config->isDebug()) {
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                'error' => true,
                'message' => 'Internal Server Error',
                'code' => 500
            ]);
        }
    }

    /**
     * Set CORS origins
     */
    public function setCorsOrigins(array $origins): self
    {
        $this->corsOrigins = $origins;
        return $this;
    }

    /**
     * Enable/disable logging
     */
    public function setLogging(bool $enabled): self
    {
        $this->enableLogging = $enabled;
        return $this;
    }

    /**
     * Add API-specific middleware
     */
    public function addApiMiddleware($middleware): self
    {
        return $this->addMiddleware($middleware);
    }

    /**
     * Create kernel for development API
     */
    public static function forDevelopment(): self
    {
        return new self(
            corsOrigins: ['*'],
            enableLogging: true
        );
    }

    /**
     * Create kernel for production API
     */
    public static function forProduction(array $allowedOrigins): self
    {
        return new self(
            corsOrigins: $allowedOrigins,
            enableLogging: true
        );
    }
}
