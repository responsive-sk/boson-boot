# Configuration System

Boson PHP používa Laravel-štýl konfiguračný systém s podporou pre dot notation, environment variables a caching.

## Základné použitie

### Čítanie konfigurácie

```php
// Základné použitie
$appName = config('app.name');

// S default hodnotou
$debug = config('app.debug', false);

// Vnorené hodnoty
$dbHost = config('database.connections.mysql.host');
$searchMinLength = config('blog.search.min_length');
```

### Environment Variables

```php
// config/app.php
return [
    'name' => env('APP_NAME', 'Boson PHP'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost:8080'),
];
```

## Štruktúra konfigurácie

### Hlavné config súbory

| Súbor | Popis | Kľúčové nastavenia |
|-------|-------|-------------------|
| `config/app.php` | Aplikačné nastavenia | name, debug, url, timezone, admin |
| `config/themes.php` | Témy a assets | default, available, assets |
| `config/database.php` | Databáza | connections, migrations |
| `config/blog.php` | Blog a search | articles_per_page, search |
| `config/view.php` | Template engine | paths, cache_enabled |
| `config/filesystems.php` | File uploads | uploads, disks |
| `config/cache.php` | Cache systém | default, stores |
| `config/paths.php` | Path management | aliases, validation |

## Príklady konfigurácie

### Aplikácia (app.php)
```php
return [
    'name' => env('APP_NAME', 'Boson PHP'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost:8080'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'admin_email' => env('ADMIN_EMAIL', 'admin@bosonphp.com'),
    'admin_password' => env('ADMIN_PASSWORD', 'admin123'),
];
```

### Témy (themes.php)
```php
return [
    'default' => env('THEME', 'tailwind'),
    'available' => [
        'svelte' => [
            'name' => 'Svelte',
            'framework' => 'svelte',
            'assets_path' => 'templates/assets/svelte',
        ],
        'tailwind' => [
            'name' => 'Tailwind CSS',
            'framework' => 'tailwind',
            'assets_path' => 'templates/assets/tailwind',
        ],
    ],
    'assets' => [
        'version' => env('THEME_ASSETS_VERSION', '1.0.0'),
        'cache_busting' => env('THEME_CACHE_BUSTING', true),
    ],
];
```

### Blog (blog.php)
```php
return [
    'articles_per_page' => env('ARTICLES_PER_PAGE', 10),
    'excerpt_length' => env('BLOG_EXCERPT_LENGTH', 150),
    'search' => [
        'min_length' => env('SEARCH_MIN_LENGTH', 2),
        'max_results' => env('SEARCH_MAX_RESULTS', 50),
    ],
];
```

## Environment Variables

### .env súbor
```env
# Application
APP_NAME="Boson PHP"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8080

# Database
DB_DATABASE=./database/blog.sqlite
DB_FOREIGN_KEYS=true

# Theme
THEME=svelte  # Available: svelte, tailwind, bootstrap

# Blog
ARTICLES_PER_PAGE=10
BLOG_EXCERPT_LENGTH=150

# Search
SEARCH_MIN_LENGTH=2
SEARCH_MAX_RESULTS=50

# Admin
ADMIN_EMAIL=admin@bosonphp.com
ADMIN_PASSWORD=admin123

# Cache
CONFIG_CACHE=false
TEMPLATE_CACHE=true
TEMPLATE_CACHE_TTL=3600

# Upload
UPLOAD_PATH=./public/uploads
UPLOAD_MAX_SIZE=10485760
UPLOAD_ALLOWED_TYPES=jpg,jpeg,png,gif,webp
```

## Config Cache

### CLI nástroje
```bash
# Generovať config cache
./bin/config-cache cache

# Vymazať config cache
./bin/config-cache clear

# Zobraziť help
./bin/config-cache help
```

### Povolenie cache
```env
CONFIG_CACHE=true
```

### Cache súbor
Config cache sa ukladá do `storage/cache/config.php` a obsahuje všetky načítané konfiguračné hodnoty.

## Implementácia

### Helper funkcie

#### config()
```php
/**
 * Získaj konfiguračnú hodnotu pomocou dot notation
 */
function config(string $key, mixed $default = null): mixed
```

#### env()
```php
/**
 * Získaj environment variable s podporou pre komentáre
 */
function env(string $key, mixed $default = null): mixed
```

### Použitie v kóde

```php
// ServiceFactory
$currentTheme = config('themes.default', 'tailwind');
$cacheEnabled = config('view.cache_enabled', true);

// Database
$dbPath = config('database.connections.sqlite.database');
$foreignKeys = config('database.connections.sqlite.foreign_key_constraints', true);

// SearchController
$minLength = config('blog.search.min_length', 2);
$maxResults = config('blog.search.max_results', 50);
```

## Výhody nového systému

1. **Laravel kompatibilita** - Známa syntax `config('app.name')`
2. **Dot notation** - Vnorené hodnoty `config('database.connections.mysql.host')`
3. **Environment variables** - Flexibilné nastavenia cez `.env`
4. **Caching** - Performance optimalizácia
5. **Type safety** - Správne typované default hodnoty
6. **Jednoduchosť** - Menej kódu, lepšia čitateľnosť

## Migrácia zo starého systému

### Pred (starý systém)
```php
$config = Config::getInstance();
$dbPath = $config->getDbPath();
$articlesPerPage = $config->getArticlesPerPage();
```

### Po (nový systém)
```php
$dbPath = config('database.connections.sqlite.database');
$articlesPerPage = config('blog.articles_per_page');
```

## Best Practices

1. **Používaj env() len v config súboroch**
2. **V aplikačnom kóde používaj config()**
3. **Vždy poskytni default hodnoty**
4. **Používaj cache v produkcii**
5. **Groupuj súvisiace nastavenia do sekcií**

```php
// ✅ Správne
$debug = config('app.debug', false);

// ❌ Nesprávne
$debug = env('APP_DEBUG', false);
```
