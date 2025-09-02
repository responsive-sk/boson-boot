<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating;

use League\Plates\Engine;

/**
 * Common helper functions shared between template engines
 */
class CommonTemplateHelper
{
    /**
     * Register common helper functions to a Plates engine
     */
    public static function registerHelpers(Engine $engine): void
    {
        // HTML escaping helper
        $engine->registerFunction('escapeHtml', [TemplateHelper::class, 'escapeHtml']);

        // URL helper
        $engine->registerFunction('url', [TemplateHelper::class, 'url']);

        // Asset helper
        $engine->registerFunction('asset', [TemplateHelper::class, 'asset']);

        // Date helper
        $engine->registerFunction('formatDate', [TemplateHelper::class, 'formatDate']);

        // Excerpt helper
        $engine->registerFunction('excerpt', [TemplateHelper::class, 'excerpt']);

        // Truncate helper
        $engine->registerFunction('truncate', [TemplateHelper::class, 'truncate']);
    }

    /**
     * Register common template folders
     */
    public static function registerFolders(Engine $engine, string $templatesPath): void
    {
        $engine->addFolder('layouts', $templatesPath . '/layouts');
        $engine->addFolder('pages', $templatesPath . '/pages');
        $engine->addFolder('partials', $templatesPath . '/partials');
        $engine->addFolder('components', $templatesPath . '/components');
    }

    /**
     * Validate template path with comprehensive checks
     */
    public static function validateTemplatesPath(string $path): void
    {
        if (empty($path)) {
            throw new \InvalidArgumentException('Templates path cannot be empty');
        }

        TemplateHelper::validatePath($path);

        if (!is_dir($path)) {
            throw new \InvalidArgumentException('Templates path does not exist: ' . $path);
        }

        if (!is_readable($path)) {
            throw new \InvalidArgumentException('Templates path is not readable: ' . $path);
        }

        // Additional security check - ensure path is within expected directory structure
        $realPath = realpath($path);
        if ($realPath === false) {
            throw new \InvalidArgumentException('Templates path cannot be resolved: ' . $path);
        }

        // Check if path contains only allowed characters and structure
        if (!preg_match('#^(/[^/]+)+$#', $path)) {
            throw new \InvalidArgumentException('Templates path has invalid structure: ' . $path);
        }
    }

    /**
     * Validate template name with security checks
     */
    public static function validateTemplateName(string $template): void
    {
        // Debug log the template name being validated
        error_log("Validating template name: '{$template}'");

        if (empty($template)) {
            error_log("Template validation failed: empty template name");
            throw new \InvalidArgumentException('Template name cannot be empty');
        }

        // Basic validation for template name
        if (!preg_match('/^[a-zA-Z0-9._\/-]+(?:::[a-zA-Z0-9._\/-]+)*$/', $template)) {
            error_log("Template validation failed: invalid characters in '{$template}'");
            throw new \InvalidArgumentException('Template name contains invalid characters');
        }

        if (strlen($template) > 100) {
            error_log("Template validation failed: template name too long '{$template}'");
            throw new \InvalidArgumentException('Template name is too long');
        }

        // Prevent directory traversal
        if (strpos($template, '..') !== false) {
            error_log("Template validation failed: directory traversal in '{$template}'");
            throw new \InvalidArgumentException('Template name contains directory traversal attempt');
        }

        // Ensure template name doesn't start with slash (prevent absolute paths)
        if (str_starts_with($template, '/')) {
            error_log("Template validation failed: starts with slash '{$template}'");
            throw new \InvalidArgumentException('Template name cannot start with slash');
        }

        error_log("Template validation passed: '{$template}'");
    }

    /**
     * Secure file operations wrapper
     */
    public static function secureFileGetContents(string $filename): string
    {
        // Validate the filename
        TemplateHelper::validatePath($filename);

        if (!file_exists($filename)) {
            throw new \RuntimeException("File does not exist: {$filename}");
        }

        if (!is_readable($filename)) {
            throw new \RuntimeException("File is not readable: {$filename}");
        }

        $content = file_get_contents($filename);
        if ($content === false) {
            throw new \RuntimeException("Failed to read file: {$filename}");
        }

        return $content;
    }

    /**
     * Secure file operations wrapper for writing
     */
    public static function secureFilePutContents(string $filename, string $content): int
    {
        // Validate the filename
        TemplateHelper::validatePath($filename);

        // Ensure directory exists
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0o755, true)) {
                throw new \RuntimeException("Failed to create directory: {$dir}");
            }
        }

        $bytes = file_put_contents($filename, $content, LOCK_EX);
        if ($bytes === false) {
            throw new \RuntimeException("Failed to write file: {$filename}");
        }

        return $bytes;
    }

    /**
     * Generate secure cache key
     */
    public static function generateSecureCacheKey(string $template, array $data): string
    {
        // Validate template name
        self::validateTemplateName($template);

        $dataHash = hash('sha256', serialize($data));
        $templateHash = hash('sha256', $template);

        return "template:{$templateHash}:{$dataHash}";
    }
}
