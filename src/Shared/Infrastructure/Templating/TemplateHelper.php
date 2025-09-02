<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating;

use DateTime;
use InvalidArgumentException;

class TemplateHelper
{
    /**
     * HTML escaping helper
     */
    public static function escapeHtml(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * URL helper
     */
    public static function url(string $route, array $params = []): string
    {
        $routes = [
            'home'       => '/',
            'blog.index' => '/blog',
            'blog.show'  => '/blog/' . ($params['slug'] ?? ''),
            'docs.index' => '/docs',
            'docs.show'  => '/docs/' . ($params['version'] ?? 'latest') . '/' . ($params['slug'] ?? ''),
            'search'     => '/search',
            'about'      => '/about',
            'contact'    => '/contact',
            'privacy'    => '/privacy',
            'terms'      => '/terms',
        ];

        return $routes[$route] ?? '#';
    }

    /**
     * Asset helper
     */
    public static function asset(string $path): string
    {
        return '/assets/' . ltrim($path, '/');
    }

    /**
     * Date helper
     */
    public static function formatDate($date, string $format = 'Y-m-d'): string
    {
        if (is_string($date)) {
            $date = new DateTime($date);
        }

        return $date instanceof DateTime ? $date->format($format) : '';
    }

    /**
     * Excerpt helper
     */
    public static function excerpt(string $text, int $length = 150): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . '...';
    }

    /**
     * Truncate text helper
     */
    public static function truncate(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . $suffix;
    }

    /**
     * Validate path for security
     */
    public static function validatePath(string $path): void
    {
        if (empty($path)) {
            throw new InvalidArgumentException('Path cannot be empty');
        }

        // Check for path traversal attempts
        if (strpos($path, '..') !== false || strpos($path, '\\') !== false) {
            throw new InvalidArgumentException('Path contains invalid characters');
        }

        // Validate path length
        if (strlen($path) > 255) {
            throw new InvalidArgumentException('Path is too long');
        }

        // Validate path characters
        if (!preg_match('#^[a-zA-Z0-9._/-]+$#', $path)) {
            throw new InvalidArgumentException('Path contains invalid characters');
        }
    }

    /**
     * Validate filename
     */
    public static function validateFilename(string $filename): void
    {
        if (empty($filename)) {
            throw new InvalidArgumentException('Filename cannot be empty');
        }

        // Check for path traversal
        if (strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
            throw new InvalidArgumentException('Filename contains invalid characters');
        }

        // Validate filename characters
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            throw new InvalidArgumentException('Filename contains invalid characters');
        }

        if (strlen($filename) > 100) {
            throw new InvalidArgumentException('Filename is too long');
        }
    }
}
