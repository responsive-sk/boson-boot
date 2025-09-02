<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Controller;

use Boson\Shared\Infrastructure\Templating\ThemeManager;

/**
 * Abstraktný base controller pre maximálnu jednoduchosť a znovupoužiteľnosť
 */
abstract class AbstractController
{
    protected mixed $templateEngine;
    protected ThemeManager $themeManager;

    public function __construct(mixed $templateEngine, ThemeManager $themeManager)
    {
        $this->templateEngine = $templateEngine;
        $this->themeManager = $themeManager;
    }

    /**
     * Render template s automatickými defaults
     * @param array<string, mixed> $data
     */
    protected function render(string $template, array $data = []): string
    {
        // Automatické defaults pre všetky templates
        $defaults = [
            'themeManager' => $this->themeManager,
            'currentRoute' => $this->getCurrentRoute(),
            'title' => $this->getDefaultTitle(),
            'description' => $this->getDefaultDescription(),
        ];

        return $this->templateEngine->render($template, array_merge($defaults, $data));
    }

    /**
     * Render JSON response pre HTMX/API
     * @param array<string, mixed> $data
     */
    protected function json(array $data, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json');
        $json = json_encode($data);
        return $json !== false ? $json : '{}';
    }

    /**
     * Render HTML fragment pre HTMX
     * @param array<string, mixed> $data
     */
    protected function fragment(string $template, array $data = []): string
    {
        return $this->templateEngine->render($template, array_merge([
            'themeManager' => $this->themeManager,
        ], $data));
    }

    /**
     * Render template partial/fragment
     */
    protected function renderTemplate(string $template, array $data = []): string
    {
        return $this->templateEngine->render($template, array_merge([
            'themeManager' => $this->themeManager,
        ], $data));
    }

    /**
     * Redirect helper
     */
    protected function redirect(string $url, int $status = 302): never
    {
        header("Location: {$url}", true, $status);
        exit;
    }

    /**
     * 404 response
     */
    protected function notFound(string $message = 'Page not found'): string
    {
        http_response_code(404);
        return $this->render('pages::404', [
            'title' => '404 - Page Not Found',
            'message' => $message
        ]);
    }

    /**
     * Error response
     */
    protected function error(string $message, int $status = 500): string
    {
        http_response_code($status);
        return $this->render('pages::error', [
            'title' => "Error {$status}",
            'message' => $message,
            'status' => $status
        ]);
    }

    /**
     * Get current route name (override v child controllers)
     */
    protected function getCurrentRoute(): string
    {
        $className = (new \ReflectionClass(static::class))->getShortName();
        return strtolower(str_replace('Controller', '', $className));
    }

    /**
     * Default title (override v child controllers)
     */
    protected function getDefaultTitle(): string
    {
        return 'Boson PHP';
    }

    /**
     * Default description (override v child controllers)
     */
    protected function getDefaultDescription(): string
    {
        return 'Modern PHP application with HTMX';
    }

    /**
     * Get request parameter s validation
     */
    protected function getParam(string $key, mixed $default = null, string $type = 'string'): mixed
    {
        $value = $_GET[$key] ?? $_POST[$key] ?? $default;

        return match($type) {
            'int' => (int) $value,
            'bool' => (bool) $value,
            'array' => (array) $value,
            default => (string) $value
        };
    }

    /**
     * Build breadcrumbs helper
     * @param array<string|array<string, mixed>> $items
     * @return array<array<string, mixed>>
     */
    protected function breadcrumbs(array $items): array
    {
        $breadcrumbs = [['label' => 'Domov', 'url' => '/']];

        foreach ($items as $item) {
            $breadcrumbs[] = is_string($item)
                ? ['label' => $item]
                : $item;
        }

        return $breadcrumbs;
    }
}
