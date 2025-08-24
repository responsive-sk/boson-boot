<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use PDO;
use PDOException;
use Boson\Shared\Infrastructure\Cache\QueryCache;
use Boson\Shared\Infrastructure\Cache\FileCache;

class Database
{
    private static ?PDO $connection = null;
    private Config $config;
    private ?QueryCache $queryCache = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getConnection(): PDO
    {
        if (self::$connection === null) {
            $this->connect();
        }
        return self::$connection;
    }

    public function getQueryCache(): QueryCache
    {
        if ($this->queryCache === null) {
            $cache = new FileCache(__DIR__ . '/../../../storage/cache/queries');
            $this->queryCache = new QueryCache($this->getConnection(), $cache);
        }
        return $this->queryCache;
    }

    private function connect(): void
    {
        try {
            $dbPath = $this->config->getDbPath();
            $dbDir = dirname($dbPath);
            
            // Create database directory if it doesn't exist
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }

            $dsn = "sqlite:" . $dbPath;
            
            self::$connection = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            // Enable foreign keys
            if ($this->config->get('DB_FOREIGN_KEYS', 'true') === 'true') {
                self::$connection->exec('PRAGMA foreign_keys = ON');
            }

            // Enable WAL mode for better concurrency
            self::$connection->exec('PRAGMA journal_mode = WAL');
            
            // Optimize SQLite settings
            self::$connection->exec('PRAGMA synchronous = NORMAL');
            self::$connection->exec('PRAGMA cache_size = 10000');
            self::$connection->exec('PRAGMA temp_store = MEMORY');

        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    public function migrate(): void
    {
        $this->createBlogPostsTable();
        $this->createBlogPostsFtsTable();
        $this->createCategoriesTable();
        $this->createTagsTable();
        $this->createPostTagsTable();
        $this->createUsersTable();
        $this->createSessionsTable();
    }

    private function createBlogPostsTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS blog_posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                excerpt TEXT,
                content TEXT NOT NULL,
                featured_image TEXT,
                status TEXT DEFAULT 'draft' CHECK (status IN ('draft', 'published', 'archived')),
                category_id INTEGER,
                author_id INTEGER DEFAULT 1,
                published_at DATETIME,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id),
                FOREIGN KEY (author_id) REFERENCES users(id)
            )
        ";
        $this->getConnection()->exec($sql);

        // Create indexes
        $this->getConnection()->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_slug ON blog_posts(slug)");
        $this->getConnection()->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_status ON blog_posts(status)");
        $this->getConnection()->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_published_at ON blog_posts(published_at)");
        $this->getConnection()->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_category ON blog_posts(category_id)");
    }

    private function createBlogPostsFtsTable(): void
    {
        $sql = "
            CREATE VIRTUAL TABLE IF NOT EXISTS blog_posts_fts USING fts5(
                title,
                excerpt,
                content,
                content='blog_posts',
                content_rowid='id'
            )
        ";
        $this->getConnection()->exec($sql);

        // Create triggers to keep FTS table in sync
        $this->getConnection()->exec("
            CREATE TRIGGER IF NOT EXISTS blog_posts_fts_insert AFTER INSERT ON blog_posts BEGIN
                INSERT INTO blog_posts_fts(rowid, title, excerpt, content) 
                VALUES (new.id, new.title, new.excerpt, new.content);
            END
        ");

        $this->getConnection()->exec("
            CREATE TRIGGER IF NOT EXISTS blog_posts_fts_delete AFTER DELETE ON blog_posts BEGIN
                INSERT INTO blog_posts_fts(blog_posts_fts, rowid, title, excerpt, content) 
                VALUES('delete', old.id, old.title, old.excerpt, old.content);
            END
        ");

        $this->getConnection()->exec("
            CREATE TRIGGER IF NOT EXISTS blog_posts_fts_update AFTER UPDATE ON blog_posts BEGIN
                INSERT INTO blog_posts_fts(blog_posts_fts, rowid, title, excerpt, content) 
                VALUES('delete', old.id, old.title, old.excerpt, old.content);
                INSERT INTO blog_posts_fts(rowid, title, excerpt, content) 
                VALUES (new.id, new.title, new.excerpt, new.content);
            END
        ");
    }

    private function createCategoriesTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE,
                slug TEXT NOT NULL UNIQUE,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->getConnection()->exec($sql);
    }

    private function createTagsTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS tags (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE,
                slug TEXT NOT NULL UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->getConnection()->exec($sql);
    }

    private function createPostTagsTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS post_tags (
                post_id INTEGER,
                tag_id INTEGER,
                PRIMARY KEY (post_id, tag_id),
                FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
            )
        ";
        $this->getConnection()->exec($sql);
    }

    private function createUsersTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                name TEXT NOT NULL,
                role TEXT DEFAULT 'admin' CHECK (role IN ('admin', 'editor')),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->getConnection()->exec($sql);
    }

    private function createSessionsTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS sessions (
                id TEXT PRIMARY KEY,
                user_id INTEGER,
                data TEXT,
                expires_at DATETIME,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";
        $this->getConnection()->exec($sql);

        $this->getConnection()->exec("CREATE INDEX IF NOT EXISTS idx_sessions_expires ON sessions(expires_at)");
    }

    public function seed(): void
    {
        $this->seedUsers();
        $this->seedCategories();
        $this->seedTags();
        $this->seedBlogPosts();
    }

    private function seedUsers(): void
    {
        $config = Config::getInstance();
        $email = $config->get('ADMIN_EMAIL', 'admin@bosonphp.com');
        $password = password_hash($config->get('ADMIN_PASSWORD', 'admin123'), PASSWORD_DEFAULT);

        $sql = "INSERT OR IGNORE INTO users (email, password, name, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$email, $password, 'Admin User', 'admin']);
    }

    private function seedCategories(): void
    {
        $categories = [
            ['Tutorial', 'tutorial', 'Step-by-step guides and tutorials'],
            ['News', 'news', 'Latest news and updates'],
            ['Performance', 'performance', 'Performance tips and optimization'],
            ['Advanced', 'advanced', 'Advanced topics and techniques']
        ];

        $sql = "INSERT OR IGNORE INTO categories (name, slug, description) VALUES (?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        
        foreach ($categories as $category) {
            $stmt->execute($category);
        }
    }

    private function seedTags(): void
    {
        $tags = [
            ['PHP', 'php'],
            ['Desktop', 'desktop'],
            ['Cross-platform', 'cross-platform'],
            ['Performance', 'performance'],
            ['Tutorial', 'tutorial'],
            ['API', 'api'],
            ['Native', 'native']
        ];

        $sql = "INSERT OR IGNORE INTO tags (name, slug) VALUES (?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        
        foreach ($tags as $tag) {
            $stmt->execute($tag);
        }
    }

    private function seedBlogPosts(): void
    {
        $posts = [
            [
                'Getting Started with Boson PHP',
                'getting-started-with-boson-php',
                'Learn how to build your first desktop application with PHP using Boson.',
                'This comprehensive guide covers everything you need to know to get started with Boson PHP...',
                'published',
                1, // Tutorial category
                date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'Performance Optimization Tips',
                'performance-optimization-tips',
                'Make your Boson PHP applications run faster with these optimization techniques.',
                'Performance is crucial for desktop applications. Here are proven techniques...',
                'published',
                3, // Performance category
                date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'Building Cross-Platform Apps',
                'building-cross-platform-apps',
                'Learn how to build applications that work on Windows, macOS, and Linux.',
                'Cross-platform development with Boson PHP is straightforward...',
                'published',
                1, // Tutorial category
                date('Y-m-d H:i:s', strtotime('-3 days'))
            ]
        ];

        $sql = "INSERT OR IGNORE INTO blog_posts (title, slug, excerpt, content, status, category_id, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        
        foreach ($posts as $post) {
            $stmt->execute($post);
        }
    }
}
