<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Blog\Application\ArticleController;
use Boson\Blog\Application\ArticleService;
use Boson\Blog\Application\DocsController;
use Boson\Blog\Application\HomeController;
use Boson\Blog\Application\PageController;
use Boson\Blog\Application\Service\ArticleApplicationService;
use Boson\Shared\Application\Service\CommandBusInterface;
use Boson\Shared\Application\Service\QueryBusInterface;
use Boson\Shared\Application\Service\SimpleCommandBus;
use Boson\Shared\Application\Service\SimpleQueryBus;
use Boson\Blog\Application\Query\Handler\GetArticlesQueryHandler;
use Boson\Blog\Application\Query\Handler\GetArticleBySlugQueryHandler;
use Boson\Blog\Application\Query\Handler\GetArticlesByCategoryQueryHandler;
use Boson\Blog\Application\Query\Article\GetArticlesQuery;
use Boson\Blog\Application\Query\Article\GetArticleBySlugQuery;
use Boson\Blog\Application\Query\Article\GetArticlesByCategoryQuery;
use Boson\Blog\Application\SearchController;
use Boson\Blog\Infrastructure\SqliteArticleRepository;
use Boson\Shared\Infrastructure\Http\Middleware\RateLimitMiddleware;
use Boson\Shared\Infrastructure\Http\Middleware\SecurityHeadersMiddleware;
use Boson\Shared\Infrastructure\Templating\ThemeManager;
use Boson\Shared\Infrastructure\Templating\TemplateEngineWithCache;
use Boson\Shared\Infrastructure\Persistence\Database;
use Boson\Shared\Infrastructure\Http\Router;
use Boson\Shared\Infrastructure\Http\RouterWithMiddleware;
use Boson\Shared\Infrastructure\PathManager;
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
            $templatesPath = PathManager::templates();
            $cachePath     = PathManager::cache('templates');
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

        $controller = match ($controllerName) {
            'HomeController'   => new HomeController($templateEngine, $themeManager),
            'ArticleController' => new ArticleController($templateEngine, $themeManager),
            'DocsController'   => new DocsController($templateEngine, $themeManager),
            'SearchController' => new SearchController($templateEngine, $themeManager),
            'PageController'   => new PageController($templateEngine, $themeManager),
            default            => throw new InvalidArgumentException("Unknown controller: {$controllerName}")
        };

        // Inject dependencies for controllers that need them
        if (method_exists($controller, 'setDatabase')) {
            $controller->setDatabase($database);
        }
        if (method_exists($controller, 'setConfig')) {
            $controller->setConfig($config);
        }
        if (method_exists($controller, 'setArticleService')) {
            $controller->setArticleService($articleService);
        }
        if (method_exists($controller, 'setArticleApplicationService')) {
            $controller->setArticleApplicationService($this->createArticleApplicationService());
        }

        return $controller;
    }

    /**
     * Create Command Bus
     */
    public function createCommandBus(): CommandBusInterface
    {
        $bus = new SimpleCommandBus();

        // Register command handlers
        // TODO: Implement command handlers

        return $bus;
    }

    /**
     * Create Query Bus
     */
    public function createQueryBus(): QueryBusInterface
    {
        $bus = new SimpleQueryBus();

        // Register query handlers
        $articleService = $this->createArticleService();

        $bus->register(GetArticlesQuery::class, fn($query) => (new GetArticlesQueryHandler($articleService))->handle($query));
        $bus->register(GetArticleBySlugQuery::class, fn($query) => (new GetArticleBySlugQueryHandler($articleService))->handle($query));
        $bus->register(GetArticlesByCategoryQuery::class, fn($query) => (new GetArticlesByCategoryQueryHandler($articleService))->handle($query));

        return $bus;
    }

    /**
     * Create Article Application Service
     */
    public function createArticleApplicationService(): ArticleApplicationService
    {
        return new ArticleApplicationService(
            $this->createQueryBus(),
            $this->createCommandBus()
        );
    }
}
