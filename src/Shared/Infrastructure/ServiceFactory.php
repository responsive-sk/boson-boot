<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Blog\Application\ArticleController;
use Boson\Blog\Application\ArticleService;
use Boson\Blog\Application\DocsController;
use Boson\Blog\Application\HomeController;
use Boson\Blog\Application\PageController;
use Boson\Blog\Application\SearchController;
use Boson\Blog\Infrastructure\SqliteArticleRepository;
use Boson\Shared\Infrastructure\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\ThemeManager;
use InvalidArgumentException;

class ServiceFactory
{
    private $templateEngine;

    private ?Router $router = null;

    private ?Config $config = null;

    private ?Database $database = null;

    private ?ArticleService $articleService = null;

    private ?ThemeManager $themeManager = null;

    private ?RouterWithMiddleware $routerWithMiddleware = null;

    public function createConfig(): Config
    {
        if ($this->config === null) {
            $this->config = Config::getInstance();
        }

        return $this->config;
    }

    public function createDatabase(): Database
    {
        if ($this->database === null) {
            $this->database = new Database($this->createConfig());
        }

        return $this->database;
    }

    public function createTemplateEngine()
    {
        if ($this->templateEngine === null) {
            $config        = $this->createConfig();
            $templatesPath = __DIR__ . '/../../../templates';
            $cachePath     = __DIR__ . '/../../../storage/cache/templates';
            $cacheEnabled  = $config->get('TEMPLATE_CACHE', 'true') === 'true';
            $cacheTtl      = (int) $config->get('TEMPLATE_CACHE_TTL', '3600');

            $this->templateEngine = new TemplateEngineWithCache(
                $templatesPath,
                $cachePath,
                $cacheEnabled,
                $cacheTtl,
            );
        }

        return $this->templateEngine;
    }

    public function createRouter(): Router
    {
        if ($this->router === null) {
            $this->router = new Router();
        }

        return $this->router;
    }

    public function createArticleService(): ArticleService
    {
        if ($this->articleService === null) {
            $repository        = new SqliteArticleRepository($this->createDatabase());
            $this->articleService = new ArticleService($repository);
        }

        return $this->articleService;
    }

    public function createThemeManager(): ThemeManager
    {
        if ($this->themeManager === null) {
            $currentTheme = $_ENV['THEME'] ?? 'tailwind';
            $version = $_ENV['VERSION'] ?? '1.0.0';
            $this->themeManager = new ThemeManager($currentTheme, '/assets', $version);
        }
        return $this->themeManager;
    }

    public function createRouterWithMiddleware(): RouterWithMiddleware
    {
        if ($this->routerWithMiddleware === null) {
            $this->routerWithMiddleware = new RouterWithMiddleware();

            // Add global middleware
            $this->routerWithMiddleware->addGlobalMiddleware(new SecurityHeadersMiddleware());
            $this->routerWithMiddleware->addGlobalMiddleware(new RateLimitMiddleware());

            // Add route-specific middleware
            $this->routerWithMiddleware->addRouteMiddleware('/api/*', new RateLimitMiddleware(null, 30, 300));
        }

        return $this->routerWithMiddleware;
    }

    public function createController(string $controllerName): object
    {
        $templateEngine = $this->createTemplateEngine();
        $config         = $this->createConfig();
        $database       = $this->createDatabase();
        $articleService = $this->createArticleService();
        $themeManager   = $this->createThemeManager();

        return match ($controllerName) {
            'HomeController'   => new HomeController($templateEngine, $themeManager),
            'ArticleController' => new ArticleController($templateEngine, $database, $config, $articleService, $themeManager),
            'DocsController'   => new DocsController($templateEngine),
            'SearchController' => new SearchController($templateEngine, $database, $config),
            'PageController'   => new PageController($templateEngine),
            default            => throw new InvalidArgumentException("Unknown controller: {$controllerName}")
        };
    }
}
