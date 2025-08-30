<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Exception;
use Throwable;
use Boson\Shared\Infrastructure\Logger;

/**
 * Centralizované spracovanie chýb a výnimiek
 */
class ErrorHandler
{
    private ServiceFactory $serviceFactory;

    public function __construct(ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * Spracovanie výnimky
     */
    public function handle(Throwable $e): void
    {
        // Log error
        $this->logError($e);

        // Set appropriate HTTP status code
        $statusCode = $this->getStatusCode($e);
        http_response_code($statusCode);

        try {
            if (Environment::isDevelopment()) {
                $this->renderDebugError($e);
            } else {
                $this->renderProductionError($statusCode);
            }
        } catch (Exception $renderException) {
            // Fallback ak sa nepodarí render
            $this->renderFallbackError($e);
        }
    }

    /**
     * Debug error pre development
     */
    private function renderDebugError(Throwable $e): void
    {
        $templateEngine = $this->serviceFactory->createTemplateEngine();
        $themeManager = $this->serviceFactory->createThemeManager();

        echo $templateEngine->render('pages::debug-error', [
            'title' => 'Debug Error - ' . get_class($e),
            'exception' => $e,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'themeManager' => $themeManager,
        ]);
    }

    /**
     * Production error pre produkciu
     */
    private function renderProductionError(int $statusCode): void
    {
        $templateEngine = $this->serviceFactory->createTemplateEngine();
        $themeManager = $this->serviceFactory->createThemeManager();

        $template = match($statusCode) {
            400 => 'pages::400',
            401 => 'pages::401',
            403 => 'pages::403',
            404 => 'pages::404',
            405 => 'pages::405',
            429 => 'pages::429',
            502 => 'pages::502',
            503 => 'pages::503',
            default => 'pages::error' // 500 and others
        };

        echo $templateEngine->render($template, [
            'title' => "Error {$statusCode}",
            'status' => $statusCode,
            'message' => $this->getErrorMessage($statusCode),
            'themeManager' => $themeManager,
        ]);
    }

    /**
     * Fallback error ak sa všetko pokazí
     */
    private function renderFallbackError(Throwable $e): void
    {
        header('Content-Type: text/html; charset=utf-8');

        if (Environment::isDevelopment()) {
            echo "<h1>Internal Server Error</h1>";
            echo "<h2>Debug Information</h2>";
            echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
            echo "<h3>Stack Trace:</h3>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        } else {
            echo "<h1>Internal Server Error</h1>";
            echo "<p>Something went wrong. Please try again later.</p>";
        }
    }

    /**
     * Logovanie chyby
     */
    private function logError(Throwable $e): void
    {
        // Use centralized logger for structured logging
        $logger = new Logger();
        $logger->exception($e);

        // Also log to PHP error log for backward compatibility
        $logMessage = sprintf(
            "[%s] %s: %s in %s:%d",
            date('Y-m-d H:i:s'),
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );

        error_log($logMessage);
    }

    /**
     * Získanie HTTP status kódu z výnimky
     */
    private function getStatusCode(Throwable $e): int
    {
        // Ak má výnimka definovaný status code
        if (method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }

        // Default 500 pre všetky ostatné chyby
        return 500;
    }

    /**
     * Získanie user-friendly error message
     */
    private function getErrorMessage(int $statusCode): string
    {
        return match($statusCode) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            default => 'An error occurred'
        };
    }
}
