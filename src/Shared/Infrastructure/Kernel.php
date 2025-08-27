<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Shared\Infrastructure\Middleware\MiddlewareStack;
use Boson\Shared\Infrastructure\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Middleware\RequestHandlerMiddleware;
use Boson\Shared\Infrastructure\Middleware\LoggingMiddleware;
use Boson\Shared\Infrastructure\Performance\CompressionMiddleware;
use Exception;

/**
 * Application Kernel - Jadro aplikácie
 * Spravuje celý request lifecycle a middleware stack
 */
class Kernel
{
    private ServiceFactory $serviceFactory;
    private MiddlewareStack $middlewareStack;
    private ErrorHandler $errorHandler;
    private bool $booted = false;

    public function __construct()
    {
        // Load environment variables
        $this->loadEnvironment();

        // Initialize error handling based on environment
        $this->initializeErrorHandling();

        // Initialize services
        $this->serviceFactory = new ServiceFactory();
        $this->middlewareStack = new MiddlewareStack();
        $this->errorHandler = new ErrorHandler($this->serviceFactory);
    }

    /**
     * Spustenie aplikácie - hlavný entry point
     */
    public function run(): void
    {
        try {
            $this->boot();
            
            $request = $this->createRequest();
            $processedRequest = $this->middlewareStack->handle($request);

            $this->sendResponse($processedRequest);
            $this->terminate();

        } catch (Exception $e) {
            $this->errorHandler->handle($e);
        }
    }

    /**
     * Bootstrap aplikácie - inicializácia všetkých komponentov
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        // Validate required environment variables
        $this->validateEnvironment();

        // Start session with security settings
        SessionManager::start();

        // Initialize middleware stack
        $this->initializeMiddleware();

        $this->booted = true;
    }

    /**
     * Inicializácia middleware stacku
     * Poradie je dôležité - prvý pridaný = prvý vykonaný
     */
    private function initializeMiddleware(): void
    {
        // Security headers first
        $this->middlewareStack->add(new SecurityHeadersMiddleware());

        // Logging (only in development or if explicitly enabled)
        if (Environment::isDevelopment() || Environment::getBool('ENABLE_LOGGING', false)) {
            $this->middlewareStack->add(new LoggingMiddleware());
        }

        // Performance optimization
        $this->middlewareStack->add(new CompressionMiddleware());

        // Rate limiting (only in production or if explicitly enabled)
        if (Environment::isProduction() || Environment::getBool('ENABLE_RATE_LIMITING', false)) {
            $rateLimitConfig = $this->getRateLimitConfig();
            $this->middlewareStack->add(new RateLimitMiddleware(
                maxAttempts: $rateLimitConfig['max_attempts'],
                windowSeconds: $rateLimitConfig['window_seconds']
            ));
        }

        // Request handling last
        $this->middlewareStack->add(new RequestHandlerMiddleware($this->serviceFactory));
    }

    /**
     * Vytvorenie request objektu s všetkými potrebnými údajmi
     */
    private function createRequest(): array
    {
        return [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'uri' => $this->normalizeUri($_SERVER['REQUEST_URI'] ?? '/'),
            'server' => $_SERVER,
            'get' => $_GET,
            'post' => $_POST,
            'cookies' => $_COOKIE,
            'session' => $_SESSION ?? [],
            'files' => $_FILES ?? [],
            'headers' => $this->getRequestHeaders(),
            'timestamp' => microtime(true),
            'ip' => $this->getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'is_secure' => $this->isSecureRequest(),
        ];
    }

    /**
     * Získanie request headers
     */
    private function getRequestHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[ucwords(strtolower($header), '-')] = $value;
            }
        }
        return $headers;
    }

    /**
     * Získanie IP adresy klienta
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
     * Odoslanie response klientovi
     */
    private function sendResponse(array $processedRequest): void
    {
        // Set HTTP status code
        if (isset($processedRequest['status'])) {
            http_response_code($processedRequest['status']);
        }

        // Set custom headers
        if (isset($processedRequest['headers'])) {
            foreach ($processedRequest['headers'] as $header) {
                if (is_array($header)) {
                    header($header['name'] . ': ' . $header['value']);
                } else {
                    header($header);
                }
            }
        }

        // Send response body
        if (isset($processedRequest['response'])) {
            echo $processedRequest['response'];
        } elseif (isset($processedRequest['body'])) {
            echo $processedRequest['body'];
        } else {
            // Fallback ak middleware nevygeneroval response
            http_response_code(500);
            echo 'No response generated';
        }
    }

    /**
     * Cleanup po odoslaní response
     */
    private function terminate(): void
    {
        // Cleanup operations after response is sent
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    /**
     * Pridanie custom middleware (len pred bootom)
     */
    public function addMiddleware($middleware): self
    {
        if ($this->booted) {
            throw new \RuntimeException('Cannot add middleware after kernel has booted');
        }
        
        $this->middlewareStack->add($middleware);
        return $this;
    }

    /**
     * Získanie service factory (pre testing)
     */
    public function getServiceFactory(): ServiceFactory
    {
        return $this->serviceFactory;
    }

    /**
     * Check if kernel is booted
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * Získanie middleware stacku (pre debugging)
     */
    public function getMiddlewareStack(): MiddlewareStack
    {
        return $this->middlewareStack;
    }

    /**
     * Load environment variables
     */
    private function loadEnvironment(): void
    {
        $envPath = dirname(__DIR__, 3) . '/.env';

        if (file_exists($envPath)) {
            Environment::load($envPath);
        }
    }

    /**
     * Initialize error handling based on environment
     */
    private function initializeErrorHandling(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', Environment::isDevelopment() ? '1' : '0');
        ini_set('log_errors', '1');

        // Set error log file
        $logFile = Environment::getString('ERROR_LOG_FILE',
            dirname(__DIR__, 3) . '/storage/logs/error.log'
        );
        ini_set('error_log', $logFile);
    }

    /**
     * Validate required environment variables
     */
    private function validateEnvironment(): void
    {
        $required = [
            'APP_ENV',
            'APP_NAME'
        ];

        try {
            Environment::validateRequired($required);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(
                'Environment validation failed: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get rate limiting configuration from environment
     */
    private function getRateLimitConfig(): array
    {
        return [
            'max_attempts' => Environment::getInt('RATE_LIMIT_MAX_ATTEMPTS', 100),
            'window_seconds' => Environment::getInt('RATE_LIMIT_WINDOW_SECONDS', 300)
        ];
    }

    /**
     * Normalize URI (remove query string, decode, handle trailing slashes)
     */
    private function normalizeUri(string $uri): string
    {
        // Remove query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        // Decode URL
        $uri = rawurldecode($uri);

        // Remove trailing slashes (except for root)
        $uri = rtrim($uri, '/');

        return $uri ?: '/';
    }

    /**
     * Check if request is secure (HTTPS)
     */
    private function isSecureRequest(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }
}
