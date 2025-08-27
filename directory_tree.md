.
├── data
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
│   ├── README.md
│   ├── SECURITY.md
│   └── THEMES.md
├── src
│   ├── Blog
│   │   ├── Application
│   │   │   ├── Service
│   │   │   │   └── ArticleApplicationService.php
│   │   │   ├── ArticleController.php
│   │   │   ├── ArticleService.php
│   │   │   ├── DocsController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PageController.php
│   │   │   └── SearchController.php
│   │   ├── Domain
│   │   │   ├── Article.php
│   │   │   ├── ArticleRepository.php
│   │   │   ├── ArticleStatus.php
│   │   │   └── Author.php
│   │   └── Infrastructure
│   │       ├── AuthorRepository.php
│   │       └── SqliteArticleRepository.php
│   ├── Shared
│   │   ├── Application
│   │   │   ├── Command
│   │   │   │   ├── Article
│   │   │   │   │   ├── CreateArticleCommand.php
│   │   │   │   │   ├── DeleteArticleCommand.php
│   │   │   │   │   └── UpdateArticleCommand.php
│   │   │   │   └── Search
│   │   │   │       └── SearchArticlesCommand.php
│   │   │   ├── Controller
│   │   │   │   └── AbstractController.php
│   │   │   ├── Query
│   │   │   │   ├── Article
│   │   │   │   │   ├── GetArticleBySlugQuery.php
│   │   │   │   │   ├── GetArticleQuery.php
│   │   │   │   │   ├── GetArticlesByCategoryQuery.php
│   │   │   │   │   └── GetArticlesQuery.php
│   │   │   │   ├── Docs
│   │   │   │   └── Handler
│   │   │   │       ├── GetArticleBySlugQueryHandler.php
│   │   │   │       ├── GetArticlesByCategoryQueryHandler.php
│   │   │   │       └── GetArticlesQueryHandler.php
│   │   │   ├── Service
│   │   │   │   ├── CommandBusInterface.php
│   │   │   │   ├── QueryBusInterface.php
│   │   │   │   ├── SimpleCommandBus.php
│   │   │   │   └── SimpleQueryBus.php
│   │   │   └── Traits
│   │   │       ├── HasDatabase.php
│   │   │       └── HasValidation.php
│   │   ├── Domain
│   │   │   ├── Event
│   │   │   ├── Exception
│   │   │   └── ValueObject
│   │   │       ├── ArticleContent.php
│   │   │       ├── ArticleId.php
│   │   │       ├── ArticleStatus.php
│   │   │       ├── ArticleTitle.php
│   │   │       └── ValueObject.php
│   │   ├── Infrastructure
│   │   │   ├── Caching
│   │   │   │   ├── CacheInterface.php
│   │   │   │   ├── FileCache.php
│   │   │   │   └── QueryCache.php
│   │   │   ├── Http
│   │   │   │   ├── Middleware
│   │   │   │   │   ├── CorsMiddleware.php
│   │   │   │   │   ├── CsrfMiddleware.php
│   │   │   │   │   ├── JsonMiddleware.php
│   │   │   │   │   ├── LoggingMiddleware.php
│   │   │   │   │   ├── MiddlewareInterface.php
│   │   │   │   │   ├── MiddlewareStack.php
│   │   │   │   │   ├── RateLimitMiddleware.php
│   │   │   │   │   ├── RequestHandlerMiddleware.php
│   │   │   │   │   └── SecurityHeadersMiddleware.php
│   │   │   │   ├── ApiKernel.php
│   │   │   │   ├── Kernel.php
│   │   │   │   ├── RequestHandler.php
│   │   │   │   ├── Router.php
│   │   │   │   └── RouterWithMiddleware.php
│   │   │   ├── Monitoring
│   │   │   │   ├── CompressionMiddleware.php
│   │   │   │   └── PerformanceMonitor.php
│   │   │   ├── Persistence
│   │   │   │   └── Database.php
│   │   │   ├── Security
│   │   │   │   ├── CsrfProtection.php
│   │   │   │   ├── InputValidator.php
│   │   │   │   ├── RateLimiter.php
│   │   │   │   └── SessionManager.php
│   │   │   ├── Templating
│   │   │   │   ├── Assets
│   │   │   │   │   └── AssetManager.php
│   │   │   │   ├── TemplateEngine.php
│   │   │   │   ├── TemplateEngineWithCache.php
│   │   │   │   └── ThemeManager.php
│   │   │   ├── Application.php
│   │   │   ├── Config.php
│   │   │   ├── Environment.php
│   │   │   ├── ErrorHandler.php
│   │   │   └── ServiceFactory.php
│   │   └── Presentation
│   │       ├── Request
│   │       │   ├── ArticleRequest.php
│   │       │   └── PaginationRequest.php
│   │       ├── Response
│   │       │   ├── ArticleResponse.php
│   │       │   └── ArticlesResponse.php
│   │       └── Transformer
│   └── storage
│       └── logs
│           └── app-2025-08-27.log
├── storage
│   ├── cache
│   │   ├── templates
│   │   │   ├── 0b53efcafffe4d5572c87f91b65f805e.cache
│   │   │   ├── 1132e21aeebb2b41598f894928df7ef7.cache
│   │   │   ├── 1dea64464a1790d26679e41a00acda89.cache
│   │   │   ├── 20ae964011582a916fef2659807a16b2.cache
│   │   │   ├── 2f7e108c855d6f7394c0fb7d855cecf6.cache
│   │   │   ├── 4983666ef318da968cb3ac23294139c7.cache
│   │   │   ├── 6bf62a4320bfc0eb905358c3d0f12504.cache
│   │   │   ├── 6fd8a79df848b8d94ec1fe37cb09880d.cache
│   │   │   ├── 74c9bd5ec83d90b29efb93a936ea2928.cache
│   │   │   ├── 945b278125a693a4c15f6f30982efb15.cache
│   │   │   ├── c2503bf8fb1501484f7fe39ea5a579c1.cache
│   │   │   └── e57ce58ebebbb768eee022fec0b679bd.cache
│   │   └── .gitkeep
│   ├── logs
│   │   ├── test
│   │   ├── app-2025-08-27.log
│   │   ├── error.log
│   │   └── .gitkeep
│   ├── phpstan
│   ├── phpunit
│   │   └── test-results
│   ├── sessions
│   │   ├── test
│   │   └── .gitkeep
│   └── templates
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
│   ├── boson-theme-Original
│   │   ├── assets
│   │   │   ├── components
│   │   │   │   ├── sections
│   │   │   │   │   ├── call-to-action-section.js
│   │   │   │   │   ├── docs-toc.js
│   │   │   │   │   ├── hero-section.js
│   │   │   │   │   ├── how-it-works-section.js
│   │   │   │   │   ├── mobile-development-section.js
│   │   │   │   │   ├── nativeness-section.js
│   │   │   │   │   ├── right-choice-section.js
│   │   │   │   │   ├── segment-section.js
│   │   │   │   │   ├── solves-section.js
│   │   │   │   │   └── testimonials-section.js
│   │   │   │   └── ui
│   │   │   │       ├── logos
│   │   │   │       │   └── logo.js
│   │   │   │       ├── breadcrumbs.js
│   │   │   │       ├── button.js
│   │   │   │       ├── dots-container.js
│   │   │   │       ├── dropdown.js
│   │   │   │       ├── footer.js
│   │   │   │       ├── header.js
│   │   │   │       ├── horizontal-accordion.js
│   │   │   │       ├── mobile-header-menu.js
│   │   │   │       ├── page-title.js
│   │   │   │       ├── search-input.js
│   │   │   │       ├── slider.js
│   │   │   │       └── subtitle.js
│   │   │   ├── layout
│   │   │   │   ├── blog.js
│   │   │   │   ├── default.js
│   │   │   │   ├── docs.js
│   │   │   │   ├── landing.js
│   │   │   │   └── search.js
│   │   │   ├── styles
│   │   │   │   ├── docs.css
│   │   │   │   ├── layout.css
│   │   │   │   └── typography.css
│   │   │   ├── utils
│   │   │   │   └── sharedStyles.js
│   │   │   ├── app.css
│   │   │   └── app.js
│   │   ├── images
│   │   │   ├── icons
│   │   │   │   ├── android.svg
│   │   │   │   ├── apple.svg
│   │   │   │   ├── arrow_down.svg
│   │   │   │   ├── arrow_primary.svg
│   │   │   │   ├── arrow_secondary.svg
│   │   │   │   ├── arrow_up_header.svg
│   │   │   │   ├── arrow_up_right.svg
│   │   │   │   ├── burger-close.svg
│   │   │   │   ├── burger.svg
│   │   │   │   ├── case.svg
│   │   │   │   ├── check.svg
│   │   │   │   ├── clients.svg
│   │   │   │   ├── convenient.svg
│   │   │   │   ├── discord.svg
│   │   │   │   ├── dots_grey.svg
│   │   │   │   ├── dots_red.svg
│   │   │   │   ├── dots.svg
│   │   │   │   ├── dot.svg
│   │   │   │   ├── freebsd.svg
│   │   │   │   ├── github.svg
│   │   │   │   ├── laravel.svg
│   │   │   │   ├── linux.svg
│   │   │   │   ├── lock.svg
│   │   │   │   ├── php.svg
│   │   │   │   ├── plus.svg
│   │   │   │   ├── quote.svg
│   │   │   │   ├── red_arrow_left.svg
│   │   │   │   ├── red_arrow_right.svg
│   │   │   │   ├── rocket.svg
│   │   │   │   ├── subtitle.svg
│   │   │   │   ├── symfony.svg
│   │   │   │   ├── telegram.svg
│   │   │   │   ├── terminal.svg
│   │   │   │   ├── web.svg
│   │   │   │   └── windows.svg
│   │   │   ├── u
│   │   │   │   ├── butschster.png
│   │   │   │   ├── curve.png
│   │   │   │   ├── lee-to.png
│   │   │   │   ├── pronskiy.png
│   │   │   │   ├── roxblnfk.png
│   │   │   │   ├── saundefined.png
│   │   │   │   └── vudaltsov.png
│   │   │   ├── credits.png
│   │   │   ├── hero.svg
│   │   │   ├── icon.svg
│   │   │   ├── img_1.png
│   │   │   ├── logo.png
│   │   │   ├── logo.svg
│   │   │   └── right_choice_bg.png
│   │   ├── translations
│   │   │   └── .gitignore
│   │   └── views
│   │       ├── bundles
│   │       │   └── TwigBundle
│   │       │       └── Exception
│   │       │           ├── error404.html.twig
│   │       │           ├── error500.html.twig
│   │       │           └── error.html.twig
│   │       ├── layout
│   │       │   └── master.html.twig
│   │       ├── page
│   │       │   ├── blog
│   │       │   │   ├── partial
│   │       │   │   │   ├── articles_list.html.twig
│   │       │   │   │   └── categories_list.html.twig
│   │       │   │   ├── index_by_category.html.twig
│   │       │   │   ├── index.html.twig
│   │       │   │   └── show.html.twig
│   │       │   ├── docs
│   │       │   │   ├── partials
│   │       │   │   │   └── version_selector.html.twig
│   │       │   │   ├── index.html.twig
│   │       │   │   └── show.html.twig
│   │       │   ├── search
│   │       │   │   └── index.html.twig
│   │       │   └── home.html.twig
│   │       └── partials
│   │           ├── footer.html.twig
│   │           └── header.html.twig
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
│   │   ├── 404.php
│   │   ├── 405.php
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
│       ├── footer.php
│       ├── header.php
│       ├── hero.php
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
│   │           └── Security
│   │               └── InputValidatorTest.php
│   └── bootstrap.php
├── behat.yml
├── build-themes.js
├── cache-cleanup.php
├── cache-manager.php
├── COMMIT_MESSAGE.md
├── composer.json
├── composer.lock
├── directory_tree.md
├── .env
├── .env.example
├── .envH
├── .gitignore
├── .htaccess
├── migrate.php
├── .php-cs-fixer.cache
├── .php-cs-fixer.php
├── phpstan.neon
├── phpunit.xml
└── test_htmx_conversion.php

111 directories, 328 files
