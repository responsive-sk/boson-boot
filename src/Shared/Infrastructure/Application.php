<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Shared\Infrastructure\Middleware\MiddlewareStack;
use Boson\Shared\Infrastructure\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Middleware\RequestHandlerMiddleware;
use Boson\Shared\Infrastructure\Performance\CompressionMiddleware;
use Exception;

/**
 * Application Kernel - Centrálny bod aplikácie
 */
class Application
{
    private ServiceFactory $serviceFactory;
    private MiddlewareStack $middlewareStack;
    private ErrorHandler $errorHandler;
    private bool $booted = false;

    public function __construct()
    {
        $this->serviceFactory = new ServiceFactory();
        $this->middlewareStack = new MiddlewareStack();
        $this->errorHandler = new ErrorHandler($this->serviceFactory);
    }

    /**
     * Spustenie aplikácie
     */
    public function run(): void
    {
        try {
            $this->boot();
            
            $request = $this->createRequest();
            $processedRequest = $this->middlewareStack->handle($request);

            $this->sendResponse($processedRequest);

        } catch (Exception $e) {
            $this->errorHandler->handle($e);
        }
    }

    /**
     * Bootstrap aplikácie
     */
    private function boot(): void
    {
        if ($this->booted) {
            return;
        }

        // Start session with security settings
        SessionManager::start();

        // Initialize middleware stack
        $this->initializeMiddleware();

        $this->booted = true;
    }

    /**
     * Inicializácia middleware stacku
     */
    private function initializeMiddleware(): void
    {
        // Order matters - first added = first executed
        $this->middlewareStack->add(new SecurityHeadersMiddleware());
        $this->middlewareStack->add(new CompressionMiddleware());
        $this->middlewareStack->add(new RateLimitMiddleware());
        $this->middlewareStack->add(new RequestHandlerMiddleware($this->serviceFactory));
    }

    /**
     * Vytvorenie request objektu
     */
    private function createRequest(): array
    {
        return [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'uri' => $_SERVER['REQUEST_URI'] ?? '/',
            'server' => $_SERVER,
            'get' => $_GET,
            'post' => $_POST,
            'cookies' => $_COOKIE,
            'session' => $_SESSION ?? [],
            'headers' => $this->getRequestHeaders(),
            'timestamp' => microtime(true),
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
     * Odoslanie response
     */
    private function sendResponse(array $processedRequest): void
    {
        if (isset($processedRequest['response'])) {
            echo $processedRequest['response'];
        } else {
            // Fallback ak middleware nevygeneroval response
            http_response_code(500);
            echo 'No response generated';
        }
    }

    /**
     * Pridanie custom middleware
     */
    public function addMiddleware($middleware): self
    {
        if ($this->booted) {
            throw new \RuntimeException('Cannot add middleware after application has booted');
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
     * Check if application is booted
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }
}
