<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use Boson\Blog\Application\ArticleController;
use Boson\Blog\Application\ArticleService;
use Boson\Shared\Application\DocsController;
use Boson\Shared\Application\HomeController;
use Boson\Shared\Application\PageController;
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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Boson\Shared\Infrastructure\Exception\ServiceNotFoundException;

/**
 * Enhanced Service Factory implementing ContainerInterface
 * Provides dependency injection, service discovery, and advanced container features
 */
class ServiceFactory implements ContainerInterface
{
    private array $services = [];
    private array $factories = [];
    private array $tags = [];
    private array $shared = [];
    private array $providers = [];
    private array $extensions = [];

    private $templateEngine;
    private ?Router $router = null;
    private ?Config $config = null;
    private ?Database $database = null;
    private ?ArticleService $articleService = null;
    private ?ThemeManager $themeManager = null;
    private ?RouterWithMiddleware $routerWithMiddleware = null;

    public function __construct()
    {
        // Auto-register core services
        $this->registerCoreServices();
    }

    /**
     * Register core services that are used throughout the application
     */
    private function registerCoreServices(): void
    {
        $this->factory('config', function() { return $this->createConfig(); });
        $this->setShared('config', true);
        $this->factory('database', function() { return $this->createDatabase(); });
        $this->setShared('database', true);
        $this->factory('template_engine', function() { return $this->createTemplateEngine(); });
        $this->setShared('template_engine', true);
        $this->factory('router', function() { return $this->createRouter(); });
        $this->setShared('router', true);
        $this->factory('article_service', function() { return $this->createArticleService(); });
        $this->setShared('article_service', true);
        $this->factory('theme_manager', function() { return $this->createThemeManager(); });
        $this->setShared('theme_manager', true);
        $this->factory('router_with_middleware', function() { return $this->createRouterWithMiddleware(); });
        $this->setShared('router_with_middleware', true);
        $this->factory('command_bus', function() { return $this->createCommandBus(); });
        $this->setShared('command_bus', true);
        $this->factory('query_bus', function() { return $this->createQueryBus(); });
        $this->setShared('query_bus', true);
        $this->factory('article_application_service', function() { return $this->createArticleApplicationService(); });
        $this->setShared('article_application_service', true);

        // Tag services
        $this->tag('controller', 'home_controller');
        $this->tag('controller', 'article_controller');
        $this->tag('controller', 'docs_controller');
        $this->tag('controller', 'search_controller');
        $this->tag('controller', 'page_controller');
        $this->tag('middleware', 'security_headers_middleware');
        $this->tag('middleware', 'rate_limit_middleware');
    }

    public function set(string $id, mixed $service): void
    {
        $this->services[$id] = $service;
    }

    public function factory(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]) || isset($this->factories[$id]);
    }

    public function get(string $id): mixed
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (isset($this->factories[$id])) {
            $service = call_user_func($this->factories[$id], $this);
            
            if ($this->isShared($id)) {
                $this->services[$id] = $service;
            }
            
            return $service;
        }

        // Auto-wiring for common services
        if (method_exists($this, 'create' . str_replace(' ', '', ucwords(str_replace('_', ' ', $id))))) {
            $method = 'create' . str_replace(' ', '', ucwords(str_replace('_', ' ', $id)));
            $service = $this->$method();
            
            if ($this->isShared($id)) {
                $this->services[$id] = $service;
            }
            
            return $service;
        }

        throw new ServiceNotFoundException("Service '$id' not found");
    }

    public function tag(string $tag, string $serviceId): void
    {
        $this->tags[$tag][] = $serviceId;
    }

    public function getTagged(string $tag): array
    {
        $services = [];
        foreach ($this->tags[$tag] ?? [] as $serviceId) {
            $services[] = $this->get($serviceId);
        }
        return $services;
    }

    public function register(ServiceProviderInterface $provider): void
    {
        $this->providers[] = $provider;
        $provider->register($this);
    }

    public function extend(string $id, callable $extender): void
    {
        $this->extensions[$id][] = $extender;
    }

    public function getServiceIds(): array
    {
        return array_merge(array_keys($this->services), array_keys($this->factories));
    }

    public function isShared(string $id): bool
    {
        return $this->shared[$id] ?? true; // Default to shared
    }

    public function setShared(string $id, bool $shared = true): void
    {
        $this->shared[$id] = $shared;
    }

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
            $this->database = new Database();
        }

        return $this->database;
    }

    public function createTemplateEngine()
    {
        if ($this->templateEngine === null) {
            $templatesPath = PathManager::templates();
            $cachePath     = PathManager::cache('templates');
            $cacheEnabled  = config('view.cache_enabled', true);
            $cacheTtl      = config('view.cache_ttl', 3600);

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

    private function createArticleController($templateEngine, $themeManager): ArticleController
    {
        $controller = new ArticleController($templateEngine, $themeManager);
        $controller->setArticleApplicationService($this->createArticleApplicationService());
        return $controller;
    }

    public function createThemeManager(): ThemeManager
    {
        if ($this->themeManager === null) {
            $currentTheme = config('themes.default', 'tailwind');
            $availableThemes = array_keys(config('themes.available', ['tailwind' => []]));
            
            // Validate theme and fallback to default if invalid
            if (!in_array($currentTheme, $availableThemes)) {
                $currentTheme = 'tailwind';
            }

            $assetsPath = config('themes.assets.public_path', '/assets');
            $version = config('themes.assets.version', '1.0.0');
            
            $this->themeManager = new ThemeManager($currentTheme, $assetsPath, $version);
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
        $database       = $this->createDatabase();
        $articleService = $this->createArticleService();
        $themeManager   = $this->createThemeManager();

        $controller = match ($controllerName) {
            'HomeController'   => new HomeController($templateEngine, $themeManager),
            'ArticleController' => $this->createArticleController($templateEngine, $themeManager),
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

        $bus->register(GetArticlesQuery::class, function($query) use ($articleService) { return (new GetArticlesQueryHandler($articleService))->handle($query); });
        $bus->register(GetArticleBySlugQuery::class, function($query) use ($articleService) { return (new GetArticleBySlugQueryHandler($articleService))->handle($query); });
        $bus->register(GetArticlesByCategoryQuery::class, function($query) use ($articleService) { return (new GetArticlesByCategoryQueryHandler($articleService))->handle($query); });

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

    /**
     * Boot all registered service providers
     */
    public function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot($this);
        }
    }

    /**
     * Get all registered providers
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * Clear all services (for testing)
     */
    public function clear(): void
    {
        $this->services = [];
        $this->factories = [];
        $this->tags = [];
        $this->shared = [];
        $this->extensions = [];
        
        // Reset cached instances
        $this->templateEngine = null;
        $this->router = null;
        $this->config = null;
        $this->database = null;
        $this->articleService = null;
        $this->themeManager = null;
        $this->routerWithMiddleware = null;
    }
}
