<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Shared\Infrastructure\Cache\CacheInterface;
use Boson\Shared\Infrastructure\Cache\FileCache;
use DateTime;
use League\Plates\Engine;

use function is_string;
use function strlen;

class TemplateEngine
{
    private Engine $plates;

    private CacheInterface $cache;

    private bool $cacheEnabled;

    public function __construct(?string $templatesPath = null, ?CacheInterface $cache = null, bool $cacheEnabled = true)
    {
        $templatesPath ??= __DIR__ . '/../../../templates';
        $this->plates       = new Engine($templatesPath);
        $this->cache        = $cache ?? new FileCache(__DIR__ . '/../../../storage/templates');
        $this->cacheEnabled = $cacheEnabled;

        // Register template folders
        $this->plates->addFolder('layout', $templatesPath . '/layout');
        $this->plates->addFolder('pages', $templatesPath . '/pages');
        $this->plates->addFolder('partials', $templatesPath . '/partials');
        $this->plates->addFolder('components', $templatesPath . '/components');

        // Register helper functions
        $this->registerHelpers();
    }

    public function render(string $template, array $data = []): string
    {
        if (!$this->cacheEnabled) {
            return $this->plates->render($template, $data);
        }

        $cacheKey = $this->generateCacheKey($template, $data);
        $cached   = $this->cache->get($cacheKey);

        if ($cached !== null) {
            return $cached;
        }

        $rendered = $this->plates->render($template, $data);

        // Cache for 1 hour by default
        $this->cache->set($cacheKey, $rendered, 3600);

        return $rendered;
    }

    public function clearCache(): bool
    {
        return $this->cache->clear();
    }

    public function setCacheEnabled(bool $enabled): void
    {
        $this->cacheEnabled = $enabled;
    }

    public function getEngine(): Engine
    {
        return $this->plates;
    }

    private function generateCacheKey(string $template, array $data): string
    {
        $dataHash = md5(serialize($data));

        return "template:{$template}:{$dataHash}";
    }

    private function registerHelpers(): void
    {
        // HTML escaping helper (Plates uses 'e' by default, but we need 'escapeHtml')
        $this->plates->registerFunction('escapeHtml', static function (string $string): string {
            return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        });

        // URL helper
        $this->plates->registerFunction('url', static function (string $route, array $params = []): string {
            // Simple URL generation - can be enhanced later
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
        });

        // Asset helper
        $this->plates->registerFunction('asset', static function (string $path): string {
            return '/assets/' . ltrim($path, '/');
        });

        // Date helper
        $this->plates->registerFunction('formatDate', static function ($date, string $format = 'Y-m-d'): string {
            if (is_string($date)) {
                $date = new DateTime($date);
            }

            return $date instanceof DateTime ? $date->format($format) : '';
        });

        // Excerpt helper
        $this->plates->registerFunction('excerpt', static function (string $text, int $length = 150): string {
            if (strlen($text) <= $length) {
                return $text;
            }

            return substr($text, 0, $length) . '...';
        });
    }
}
