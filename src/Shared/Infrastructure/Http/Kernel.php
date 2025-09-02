<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareStack;
use Boson\Shared\Infrastructure\Http\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\Http\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Http\Middleware\RequestHandlerMiddleware;
use Boson\Shared\Infrastructure\Http\Middleware\LoggingMiddleware;
// use Boson\Shared\Infrastructure\Monitoring\CompressionMiddleware;
use Boson\Shared\Infrastructure\Http\Psr15\Psr15Kernel as Psr15KernelImpl;
use Boson\Shared\Infrastructure\Http\Psr15\Middleware\Psr15LoggingMiddleware;
use Boson\Shared\Infrastructure\Monitoring\PerformanceMonitor;
use Exception;
use Boson\Shared\Infrastructure\Environment;
use Boson\Shared\Infrastructure\ErrorHandler;
use Boson\Shared\Infrastructure\ServiceFactory;
use Boson\Shared\Infrastructure\Security\SessionManager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

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
    private bool $psr15Mode = false;
    private ?Psr15KernelImpl $psr15Kernel = null;

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

        // Initialize PSR-15 kernel
        $monitor = PerformanceMonitor::getInstance();
        $this->psr15Kernel = new Psr15KernelImpl(new RequestHandler($this->serviceFactory, $monitor));
    }

    /**
     * Spustenie aplikácie - hlavný entry point
     */
    public function run(): void
    {
        try {
            $this->boot();

            if ($this->psr15Mode && $this->psr15Kernel) {
                // PSR-15 mode
                $psrRequest = $this->createPsr7Request();
                $psrResponse = $this->psr15Kernel->handlePsr7($psrRequest);
                $this->sendPsr7Response($psrResponse);
            } else {
                // Legacy array-based mode
                $request = $this->createRequest();
                try {
                    $processedRequest = $this->middlewareStack->handle($request);
                    $this->sendResponse($processedRequest);
                } catch (\Throwable $e) {
                    error_log("Kernel middleware error: " . $e->getMessage());
                    error_log("Trace: " . $e->getTraceAsString());
                    http_response_code(500);
                    echo "Internal Server Error";
                }
            }

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
        if ($this->psr15Mode && $this->psr15Kernel) {
            $this->initializePsr15Middleware();
        } else {
            $this->initializeLegacyMiddleware();
        }
    }

    /**
     * Initialize PSR-15 middleware stack
     */
    private function initializePsr15Middleware(): void
    {
        // PSR-15 Logging middleware
        if (Environment::isDevelopment() || Environment::getBool('ENABLE_LOGGING', false)) {
            $psr15Logger = new Psr15LoggingMiddleware($this->serviceFactory->getLogger());
            $this->psr15Kernel->addPsr15Middleware($psr15Logger);
        }

        // Add custom middlewares wrapped in PSR-15 adapters
        $this->psr15Kernel->addCustomMiddleware(new SecurityHeadersMiddleware());

        // Rate limiting (only in production or if explicitly enabled)
        if (Environment::isProduction() || Environment::getBool('ENABLE_RATE_LIMITING', false)) {
            $rateLimitConfig = $this->getRateLimitConfig();
            $this->psr15Kernel->addCustomMiddleware(new RateLimitMiddleware(
                maxAttempts: $rateLimitConfig['max_attempts'],
                windowSeconds: $rateLimitConfig['window_seconds']
            ));
        }

        // Request handling last
        $this->psr15Kernel->addCustomMiddleware(new RequestHandlerMiddleware($this->serviceFactory));
    }

    /**
     * Initialize legacy middleware stack
     */
    private function initializeLegacyMiddleware(): void
    {
        // Security headers first
        $this->middlewareStack->add(new SecurityHeadersMiddleware());

        // Logging - DISABLED to prevent headers already sent error
        if (Environment::isDevelopment() || Environment::getBool('ENABLE_LOGGING', false)) {
            $this->middlewareStack->add(new LoggingMiddleware());
        }

        // Performance optimization - DISABLED to prevent headers already sent error
        // $this->middlewareStack->add(new CompressionMiddleware());

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
                $headerName = ucwords(strtolower($header), '-');
                $headers[] = "{$headerName}: {$value}";
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

        // Set custom headers (with binary data protection and validation)
        if (isset($processedRequest['headers']) && !headers_sent()) {
            foreach ($processedRequest['headers'] as $header) {
                if (is_array($header)) {
                    // Sanitize header values to prevent binary data
                    $name = preg_replace('/[^\x20-\x7E]/', '', (string)$header['name']);
                    $value = preg_replace('/[^\x20-\x7E]/', '', (string)$header['value']);
                    
                    // Validate header name format
                    if ($name && $value && preg_match('/^[a-zA-Z0-9\-]+$/', $name) && !headers_sent()) {
                        header($name . ': ' . $value);
                    }
                } else {
                    // Sanitize and validate simple header strings
                    $cleanHeader = preg_replace('/[^\x20-\x7E]/', '', (string)$header);
                    
                    if ($cleanHeader && strpos($cleanHeader, ':') !== false) {
                        list($headerName, $headerValue) = explode(':', $cleanHeader, 2);
                        $headerName = trim($headerName);
                        $headerValue = trim($headerValue);
                        
                        // Validate header name according to RFC 7230
                        if (preg_match('/^[a-zA-Z0-9\-]+$/', $headerName) && !headers_sent()) {
                            header("{$headerName}: {$headerValue}");
                        } else {
                            error_log("Skipping invalid header name: " . substr($headerName, 0, 50));
                        }
                    } else {
                        error_log("Skipping malformed header: " . substr($cleanHeader, 0, 50));
                    }
                }
            }
        }

        // Send response body (with binary data check)
        if (isset($processedRequest['response'])) {
            $response = $processedRequest['response'];
            // Check for binary data in response
            if (is_string($response) && !mb_check_encoding($response, 'UTF-8')) {
                error_log('Binary data detected in response, converting to safe output');
                echo 'Response contains binary data - check logs';
            } else {
                echo $response;
            }
        } elseif (isset($processedRequest['body'])) {
            $body = $processedRequest['body'];
            // Check for binary data in body
            if (is_string($body) && !mb_check_encoding($body, 'UTF-8')) {
                error_log('Binary data detected in body, converting to safe output');
                echo 'Body contains binary data - check logs';
            } else {
                echo $body;
            }
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
        $envPath = dirname(__DIR__, 4) . '/.env';

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
        ini_set('display_errors', '1'); // Always show errors for debugging
        ini_set('log_errors', '1');

        // Set error log file
        $logFile = Environment::getString('ERROR_LOG_FILE',
            dirname(__DIR__, 3) . '/storage/logs/error.log'
        );
        ini_set('error_log', $logFile);

        // Also log to a custom file for debugging
        ini_set('error_log', dirname(__DIR__, 3) . '/storage/logs/debug.log');
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

    /**
     * Enable PSR-15 mode
     */
    public function enablePsr15Mode(): self
    {
        if ($this->booted) {
            throw new \RuntimeException('Cannot change PSR-15 mode after kernel has booted');
        }

        $this->psr15Mode = true;
        if ($this->psr15Kernel) {
            $this->psr15Kernel->enablePsr15Mode();
        }
        return $this;
    }

    /**
     * Disable PSR-15 mode (use legacy mode)
     */
    public function disablePsr15Mode(): self
    {
        if ($this->booted) {
            throw new \RuntimeException('Cannot change PSR-15 mode after kernel has booted');
        }

        $this->psr15Mode = false;
        if ($this->psr15Kernel) {
            $this->psr15Kernel->disablePsr15Mode();
        }
        return $this;
    }

    /**
     * Check if PSR-15 mode is enabled
     */
    public function isPsr15Mode(): bool
    {
        return $this->psr15Mode;
    }

    /**
     * Add PSR-15 middleware
     */
    public function addPsr15Middleware($middleware): self
    {
        if (!$this->psr15Kernel) {
            throw new \RuntimeException('PSR-15 kernel not initialized');
        }

        $this->psr15Kernel->addPsr15Middleware($middleware);
        return $this;
    }

    /**
     * Handle PSR-7 request directly (for testing or programmatic use)
     */
    public function handlePsr7(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->psr15Kernel) {
            throw new \RuntimeException('PSR-15 kernel not initialized');
        }

        $this->boot();
        return $this->psr15Kernel->handlePsr7($request);
    }

    /**
     * Handle array-based request directly (for testing or programmatic use)
     */
    public function handleArray(array $request): array
    {
        $this->boot();

        if ($this->psr15Mode && $this->psr15Kernel) {
            return $this->psr15Kernel->handleArray($request);
        }

        return $this->middlewareStack->handle($request);
    }

    /**
     * Create PSR-7 ServerRequest from current HTTP request
     */
    private function createPsr7Request(): ServerRequestInterface
    {
        $arrayRequest = $this->createRequest();
        return new \Boson\Shared\Infrastructure\Http\Psr15\PsrRequestAdapter($arrayRequest);
    }

    /**
     * Send PSR-7 Response to client
     */
    private function sendPsr7Response(ResponseInterface $response): void
    {
        // Set HTTP status code
        http_response_code($response->getStatusCode());

        // Set headers
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header($name . ': ' . $value, false);
            }
        }

        // Send response body
        $body = $response->getBody();
        if ($body->isReadable()) {
            echo $body->getContents();
        }
    }

    /**
     * Get PSR-15 kernel instance
     */
    public function getPsr15Kernel(): ?Psr15KernelImpl
    {
        return $this->psr15Kernel;
    }
}
