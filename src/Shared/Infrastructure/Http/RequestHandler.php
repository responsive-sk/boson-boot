<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http;

use Boson\Shared\Infrastructure\Monitoring\PerformanceMonitor;
use Boson\Shared\Infrastructure\ServiceFactory;
use FastRoute\Dispatcher;
use Exception;

class RequestHandler
{
    private ServiceFactory $serviceFactory;
    private PerformanceMonitor $monitor;

    public function __construct(ServiceFactory $serviceFactory, PerformanceMonitor $monitor)
    {
        $this->serviceFactory = $serviceFactory;
        $this->monitor = $monitor;
    }

    /**
     * @param array{0: int, 1: mixed, 2: array<string, mixed>} $routeInfo
     */
    public function handle(string $httpMethod, string $uri): string
    {
        try {
            $router = $this->serviceFactory->createRouter();
            $routeInfo = $router->dispatch($httpMethod, $uri);

            if (!is_array($routeInfo) || !isset($routeInfo[0])) {
                return $this->handleError('Invalid route info', 500);
            }

            $this->monitor->checkpoint('route_dispatched');

            return match ($routeInfo[0]) {
                Dispatcher::NOT_FOUND => $this->handleNotFound(),
                Dispatcher::METHOD_NOT_ALLOWED => $this->handleMethodNotAllowed($routeInfo[1] ?? []),
                Dispatcher::FOUND => $this->handleFoundRoute($routeInfo),
                default => $this->handleError('Unknown route status', 500)
            };

        } catch (Exception $e) {
            error_log("Request handling failed: " . $e->getMessage());
            return $this->handleError('Internal Server Error', 500);
        }
    }

    /**
     * @param array{0: int, 1: mixed, 2: array<string, mixed>} $routeInfo
     */
    private function handleFoundRoute(array $routeInfo): string
    {
        $handler = $routeInfo[1] ?? null;
        $vars = $routeInfo[2] ?? [];

        if ($handler === null) {
            return $this->handleError('Invalid route handler', 500);
        }

        $this->monitor->checkpoint('route_found');

        try {
            if (is_callable($handler)) {
                $response = $handler($vars);
            } else {
                $handlerParts = explode('@', (string) $handler);
                if (count($handlerParts) !== 2) {
                    return $this->handleError('Invalid controller method format', 500);
                }

                [$controller, $method] = $handlerParts;
                $controllerInstance = $this->serviceFactory->createController($controller);

                if (!method_exists($controllerInstance, $method)) {
                    return $this->handleError('Controller method not found', 500);
                }

                $response = $controllerInstance->$method($vars);
            }

            $this->monitor->checkpoint('response_generated');

            // Add debug info in development
            $config = $this->serviceFactory->createConfig();
            if ($config->isDebug()) {
                $this->monitor->addDebugHeader();
                $response .= $this->monitor->renderDebugInfo();
            }

            return $response;

        } catch (Exception $e) {
            error_log("Controller execution failed: " . $e->getMessage());
            return $this->handleError('Controller Error', 500);
        }
    }

    private function handleNotFound(): string
    {
        if (php_sapi_name() !== 'cli' && !headers_sent()) {
            http_response_code(404);
        }

        try {
            $templateEngine = $this->serviceFactory->createTemplateEngine();
            $themeManager = $this->serviceFactory->createThemeManager();

            return $templateEngine->render('pages::404', [
                'title' => '404 - Page Not Found',
                'themeManager' => $themeManager
            ]);
        } catch (Exception $e) {
            return '404 Not Found';
        }
    }

    private function handleMethodNotAllowed(array $allowedMethods): string
    {
        if (php_sapi_name() !== 'cli' && !headers_sent()) {
            http_response_code(405);
            header('Allow: ' . implode(', ', $allowedMethods));
        }

        try {
            $templateEngine = $this->serviceFactory->createTemplateEngine();
            $themeManager = $this->serviceFactory->createThemeManager();

            return $templateEngine->render('pages::405', [
                'title' => '405 - Method Not Allowed',
                'allowedMethods' => $allowedMethods,
                'themeManager' => $themeManager
            ]);
        } catch (Exception $e) {
            return '405 Method Not Allowed';
        }
    }

    private function handleError(string $message, int $status): string
    {
        // Set HTTP status code only if not in CLI and headers not sent
        if (php_sapi_name() !== 'cli' && !headers_sent()) {
            http_response_code($status);
        }

        $config = null;
        try {
            $config = $this->serviceFactory->createConfig();
            $templateEngine = $this->serviceFactory->createTemplateEngine();
            $themeManager = $this->serviceFactory->createThemeManager();

            return $templateEngine->render('pages::error', [
                'title' => "Error {$status}",
                'message' => $config->isDebug() ? $message : 'An error occurred',
                'status' => $status,
                'themeManager' => $themeManager
            ]);
        } catch (Exception $e) {
            $debugMessage = $config !== null && $config->isDebug() ? $message : 'Internal Server Error';
            return $debugMessage;
        }
    }
}
