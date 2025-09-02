<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Templating;

use Boson\Shared\Infrastructure\Caching\CacheInterface;
use Boson\Shared\Infrastructure\Caching\FileCache;
use Boson\Shared\Infrastructure\PathManager;
use Boson\Shared\Infrastructure\Templating\TemplateHelper;
use DateTime;
use League\Plates\Engine;
use InvalidArgumentException;

use function is_string;
use function strlen;

class TemplateEngine
{
    private Engine $plates;

    private CacheInterface $cache;

    private bool $cacheEnabled;

    public function __construct(?string $templatesPath = null, ?CacheInterface $cache = null, bool $cacheEnabled = true)
    {
        $templatesPath ??= PathManager::templates();
        $this->validateTemplatesPath($templatesPath);

        $this->plates       = new Engine($templatesPath);
        $this->cache        = $cache ?? new FileCache(PathManager::storage('templates'));
        $this->cacheEnabled = $cacheEnabled;

        // Register template folders and helpers using common helper
        CommonTemplateHelper::registerFolders($this->plates, $templatesPath);
        CommonTemplateHelper::registerHelpers($this->plates);
    }

    public function render(string $template, array $data = []): string
    {
        // Debug log for template name
        error_log("TemplateEngine: Starting render of template: '{$template}'");

        try {
            $this->validateTemplate($template);
            error_log("TemplateEngine: Template validation passed for: '{$template}'");
        } catch (\Throwable $e) {
            error_log("TemplateEngine: Template validation failed for: '{$template}' - " . $e->getMessage());
            throw $e;
        }

        try {
            if (!$this->cacheEnabled) {
                error_log("TemplateEngine: Rendering without cache: '{$template}'");
                return $this->plates->render($template, $data);
            }

            $cacheKey = $this->generateCacheKey($template, $data);
            $cached   = $this->cache->get($cacheKey);

            if ($cached !== null) {
                error_log("TemplateEngine: Cache hit for: '{$template}'");
                return $cached;
            }

            error_log("TemplateEngine: Cache miss, rendering: '{$template}'");
            $rendered = $this->plates->render($template, $data);

            // Cache for 1 hour by default
            $this->cache->set($cacheKey, $rendered, 3600);

            return $rendered;
        } catch (\League\Plates\Exception\TemplateNotFound $e) {
            error_log("TemplateEngine: Template not found: '{$template}'");
            throw new \RuntimeException("Template '{$template}' not found in templates directory", 0, $e);
        } catch (\Throwable $e) {
            error_log("TemplateEngine: Error rendering template '{$template}': " . $e->getMessage());
            throw new \RuntimeException("Error rendering template '{$template}': " . $e->getMessage(), 0, $e);
        }
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



    private function validateTemplatesPath(string $path): void
    {
        CommonTemplateHelper::validateTemplatesPath($path);
    }

    private function validateTemplate(string $template): void
    {
        CommonTemplateHelper::validateTemplateName($template);
    }
}
