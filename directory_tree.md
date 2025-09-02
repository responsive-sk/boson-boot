.
├── bin
│   ├── build-responsive-sk
│   ├── cache-cleanup
│   └── migrate
├── config
│   ├── app.php
│   ├── auth.php
│   ├── blog.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── hashing.php
│   ├── logging.php
│   ├── queue.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database
│   ├── migrations
│   │   └── 002_rename_blog_posts_to_articles.sql
│   ├── seeders
│   │   └── ArticleSeeder.php
│   ├── blog.sqlite
│   └── seed.php
├── docs
│   ├── ASSETS.md
│   ├── INDEX.md
│   ├── KERNEL.md
│   ├── PERFORMANCE.md
│   ├── PLAN.md
│   ├── PSR15-README.md
│   ├── README.md
│   ├── SECURITY.md
│   └── THEMES.md
├── examples
│   └── psr15-demo.php
├── src
│   ├── Blog
│   │   ├── Application
│   │   │   ├── Command
│   │   │   │   ├── Article
│   │   │   │   │   ├── CreateArticleCommand.php
│   │   │   │   │   ├── DeleteArticleCommand.php
│   │   │   │   │   └── UpdateArticleCommand.php
│   │   │   │   └── Search
│   │   │   │       └── SearchArticlesCommand.php
│   │   │   ├── Query
│   │   │   │   ├── Article
│   │   │   │   │   ├── GetArticleBySlugQuery.php
│   │   │   │   │   ├── GetArticleQuery.php
│   │   │   │   │   ├── GetArticlesByCategoryQuery.php
│   │   │   │   │   └── GetArticlesQuery.php
│   │   │   │   └── Handler
│   │   │   │       ├── GetArticleBySlugQueryHandler.php
│   │   │   │       ├── GetArticlesByCategoryQueryHandler.php
│   │   │   │       └── GetArticlesQueryHandler.php
│   │   │   ├── Service
│   │   │   │   └── ArticleApplicationService.php
│   │   │   ├── ArticleController.php
│   │   │   ├── ArticleService.php
│   │   │   └── SearchController.php
│   │   ├── Domain
│   │   │   ├── ValueObject
│   │   │   │   ├── ArticleContent.php
│   │   │   │   ├── ArticleId.php
│   │   │   │   ├── ArticleStatus.php
│   │   │   │   └── ArticleTitle.php
│   │   │   ├── Article.php
│   │   │   ├── ArticleRepository.php
│   │   │   ├── ArticleStatus.php
│   │   │   └── Author.php
│   │   ├── Infrastructure
│   │   │   ├── AuthorRepository.php
│   │   │   └── SqliteArticleRepository.php
│   │   └── Presentation
│   │       ├── Request
│   │       │   └── ArticleRequest.php
│   │       └── Response
│   │           ├── ArticleResponse.php
│   │           └── ArticlesResponse.php
│   └── Shared
│       ├── Application
│       │   ├── Command
│       │   │   └── Search
│       │   ├── Controller
│       │   │   └── AbstractController.php
│       │   ├── Query
│       │   │   └── Docs
│       │   ├── Service
│       │   │   ├── CommandBusInterface.php
│       │   │   ├── QueryBusInterface.php
│       │   │   ├── SimpleCommandBus.php
│       │   │   └── SimpleQueryBus.php
│       │   ├── Traits
│       │   │   ├── HasDatabase.php
│       │   │   └── HasValidation.php
│       │   ├── DocsController.php
│       │   ├── HomeController.php
│       │   └── PageController.php
│       ├── Domain
│       │   ├── Event
│       │   ├── Exception
│       │   └── ValueObject
│       │       └── ValueObject.php
│       ├── Infrastructure
│       │   ├── Caching
│       │   │   ├── CacheInterface.php
│       │   │   ├── FileCache.php
│       │   │   └── QueryCache.php
│       │   ├── Exception
│       │   │   └── ServiceNotFoundException.php
│       │   ├── Http
│       │   │   ├── Middleware
│       │   │   │   ├── CorsMiddleware.php
│       │   │   │   ├── CsrfMiddleware.php
│       │   │   │   ├── JsonMiddleware.php
│       │   │   │   ├── LoggingMiddleware.php
│       │   │   │   ├── MiddlewareInterface.php
│       │   │   │   ├── MiddlewareStack.php
│       │   │   │   ├── RateLimitMiddleware.php
│       │   │   │   ├── RequestHandlerMiddleware.php
│       │   │   │   └── SecurityHeadersMiddleware.php
│       │   │   ├── Psr15
│       │   │   │   ├── Middleware
│       │   │   │   │   └── Psr15LoggingMiddleware.php
│       │   │   │   ├── Psr15Kernel.php
│       │   │   │   ├── Psr15MiddlewareAdapter.php
│       │   │   │   ├── Psr15MiddlewareStack.php
│       │   │   │   ├── Psr15RequestHandler.php
│       │   │   │   ├── PsrRequestAdapter.php
│       │   │   │   └── PsrResponseAdapter.php
│       │   │   ├── ApiKernel.php
│       │   │   ├── Kernel.php
│       │   │   ├── RequestHandler.php
│       │   │   ├── Router.php
│       │   │   └── RouterWithMiddleware.php
│       │   ├── Monitoring
│       │   │   ├── CompressionMiddleware.php
│       │   │   └── PerformanceMonitor.php
│       │   ├── Path
│       │   │   ├── FilePathCache.php
│       │   │   ├── PathCacheInterface.php
│       │   │   ├── PathEventInterface.php
│       │   │   ├── PathEvent.php
│       │   │   └── PathResolverInterface.php
│       │   ├── Persistence
│       │   │   └── Database.php
│       │   ├── Security
│       │   │   ├── CsrfProtection.php
│       │   │   ├── InputValidator.php
│       │   │   ├── RateLimiter.php
│       │   │   └── SessionManager.php
│       │   ├── Templating
│       │   │   ├── Assets
│       │   │   │   └── AssetManager.php
│       │   │   ├── TemplateEngine.php
│       │   │   ├── TemplateEngineWithCache.php
│       │   │   └── ThemeManager.php
│       │   ├── Application.php
│       │   ├── Config.php
│       │   ├── ContainerInterface.php
│       │   ├── Environment.php
│       │   ├── ErrorHandler.php
│       │   ├── Logger.php
│       │   ├── PathManager.php
│       │   ├── ServiceFactory.php
│       │   └── ServiceProviderInterface.php
│       └── Presentation
│           ├── Request
│           │   └── PaginationRequest.php
│           ├── Response
│           └── Transformer
├── storage
│   ├── cache
│   │   ├── paths
│   │   │   ├── 51b8ba2e36e4f9a355f397909c254059.cache
│   │   │   ├── 56a20ff12f65c8998612e83965ed063f.cache
│   │   │   ├── 5d572f49ff2b6481b2637ab9e62673d9.cache
│   │   │   ├── 939504227cfe61e0d5f0313e47af45d5.cache
│   │   │   ├── b17e52dc3a248085ddc7552a3209077e.cache
│   │   │   ├── c5efdbc48a89eaf18bea8a214234616e.cache
│   │   │   ├── f8c6ad96ccf030cec75e013a91b50551.cache
│   │   │   └── fd793a7c61e372c29a3b9bbf36065a8c.cache
│   │   ├── queries
│   │   ├── templates
│   │   ├── test
│   │   └── .gitkeep
│   ├── logs
│   │   ├── test
│   │   ├── app-2025-08-30.log
│   │   ├── error.log
│   │   └── .gitkeep
│   ├── phpstan
│   ├── phpunit
│   │   └── test-results
│   └── sessions
│       ├── test
│       └── .gitkeep
├── templates
│   ├── assets
│   │   ├── bootstrap
│   │   │   ├── fonts
│   │   │   │   ├── inter-400.woff2
│   │   │   │   ├── inter-500.woff2
│   │   │   │   ├── inter-600.woff2
│   │   │   │   ├── inter-700.woff2
│   │   │   │   ├── jetbrains-mono-400.woff2
│   │   │   │   ├── jetbrains-mono-500.woff2
│   │   │   │   ├── roboto-condensed-400.woff2
│   │   │   │   ├── roboto-condensed-500.woff2
│   │   │   │   ├── roboto-condensed-600.woff2
│   │   │   │   └── roboto-condensed-700.woff2
│   │   │   ├── src
│   │   │   │   ├── main.js
│   │   │   │   └── styles.scss
│   │   │   ├── package.json
│   │   │   └── vite.config.js
│   │   ├── svelte
│   │   │   ├── fonts
│   │   │   │   ├── inter-400.woff2
│   │   │   │   ├── inter-500.woff2
│   │   │   │   ├── inter-600.woff2
│   │   │   │   ├── inter-700.woff2
│   │   │   │   ├── jetbrains-mono-400.woff2
│   │   │   │   ├── jetbrains-mono-500.woff2
│   │   │   │   ├── roboto-condensed-400.woff2
│   │   │   │   ├── roboto-condensed-500.woff2
│   │   │   │   ├── roboto-condensed-600.woff2
│   │   │   │   └── roboto-condensed-700.woff2
│   │   │   ├── src
│   │   │   │   ├── components
│   │   │   │   │   ├── ArticleCard.svelte
│   │   │   │   │   ├── ArticleDetail.svelte
│   │   │   │   │   ├── Footer.svelte
│   │   │   │   │   ├── Header.svelte
│   │   │   │   │   ├── SearchModal.svelte
│   │   │   │   │   └── TailwindHero.svelte
│   │   │   │   ├── styles
│   │   │   │   │   └── main.css
│   │   │   │   ├── main.js
│   │   │   │   └── test-registry.js
│   │   │   ├── package.json
│   │   │   └── vite.config.js
│   │   └── tailwind
│   │       ├── fonts
│   │       │   ├── inter-400.woff2
│   │       │   ├── inter-500.woff2
│   │       │   ├── inter-600.woff2
│   │       │   ├── inter-700.woff2
│   │       │   ├── jetbrains-mono-400.woff2
│   │       │   ├── jetbrains-mono-500.woff2
│   │       │   ├── roboto-condensed-400.woff2
│   │       │   ├── roboto-condensed-500.woff2
│   │       │   ├── roboto-condensed-600.woff2
│   │       │   └── roboto-condensed-700.woff2
│   │       ├── src
│   │       │   ├── main.js
│   │       │   └── styles.css
│   │       ├── package.json
│   │       ├── tailwind.config.js
│   │       └── vite.config.js
│   ├── components
│   │   ├── forms
│   │   ├── sections
│   │   │   ├── call-to-action.php
│   │   │   ├── hero.php
│   │   │   ├── how-it-works.php
│   │   │   ├── mobile-development.php
│   │   │   ├── nativeness.php
│   │   │   ├── right-choice.php
│   │   │   ├── segment.php
│   │   │   ├── solves.php
│   │   │   └── testimonials.php
│   │   └── ui
│   │       ├── animated-headline.php
│   │       ├── breadcrumbs.php
│   │       ├── button.php
│   │       ├── button-simple.php
│   │       ├── card-simple.php
│   │       ├── dots-container.php
│   │       ├── form-simple.php
│   │       ├── logo.php
│   │       ├── page-title-container.php
│   │       ├── search-input.php
│   │       └── svg-dots-pattern.php
│   ├── layouts
│   │   ├── app.php
│   │   ├── base.php
│   │   ├── landing.php
│   │   └── test.php
│   ├── pages
│   │   ├── 400.php
│   │   ├── 401.php
│   │   ├── 403.php
│   │   ├── 404.php
│   │   ├── 405.php
│   │   ├── 429.php
│   │   ├── 502.php
│   │   ├── 503.php
│   │   ├── about.php
│   │   ├── article.php
│   │   ├── articles.php
│   │   ├── contact.php
│   │   ├── debug-error.php
│   │   ├── docs-article.php
│   │   ├── docs-index.php
│   │   ├── docs-version.php
│   │   ├── download.php
│   │   ├── error.php
│   │   ├── home.php
│   │   ├── privacy.php
│   │   ├── search.php
│   │   ├── terms.php
│   │   └── test.php
│   └── partials
│       ├── article-card.php
│       ├── footer.php
│       ├── header.php
│       ├── hero.php
│       ├── load-more-button.php
│       ├── rate-limit-error.php
│       ├── search-validation-error.php
│       └── validation-error.php
├── tests
│   ├── coverage
│   ├── Feature
│   │   ├── homepage.feature
│   │   └── WebContext.php
│   ├── Integration
│   │   └── Blog
│   │       └── Infrastructure
│   │           └── SqliteArticleRepositoryTest.php
│   ├── results
│   │   ├── junit.xml
│   │   ├── testdox.html
│   │   └── testdox.txt
│   ├── Unit
│   │   ├── Blog
│   │   │   └── Domain
│   │   │       └── ArticleTest.php
│   │   └── Shared
│   │       └── Infrastructure
│   │           ├── Http
│   │           │   └── Psr15
│   │           │       └── Psr15IntegrationTest.php
│   │           ├── Security
│   │           │   └── InputValidatorTest.php
│   │           └── PathManagerTest.php
│   └── bootstrap.php
├── behat.yml
├── build-themes.js
├── composer.json
├── composer.lock
├── directory_tree.md
├── EMERGENCY-RESPONSE.md
├── .env
├── .env.example
├── .env .test.responsive.sk
├── .gitignore
├── .htaccess
├── .php-cs-fixer.cache
├── .php-cs-fixer.php
├── phpstan.neon
├── phpunit.xml
├── TODO.md
├── TROUBLESHOOTING.md
└── UPLOAD-INSTRUCTIONS.txt

101 directories, 268 files
