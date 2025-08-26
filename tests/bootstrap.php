<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Config;
use Boson\Shared\Infrastructure\Database;

// Set up test environment
$_ENV['APP_ENV']            = 'testing';
$_ENV['APP_DEBUG']          = 'true';
$_ENV['DB_DATABASE']        = ':memory:';
$_ENV['TEMPLATE_CACHE']     = 'false';
$_ENV['RATE_LIMIT_ENABLED'] = 'false';

// Create test directories
$testDirs = [
    __DIR__ . '/coverage',
    __DIR__ . '/results',
    __DIR__ . '/../storage/cache/test',
    __DIR__ . '/../storage/sessions/test',
    __DIR__ . '/../storage/logs/test',
];

foreach ($testDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0o755, true);
    }
}

// Test helper functions
function createTestDatabase(): Database
{
    $config   = Config::getInstance();
    $database = new Database($config);

    // Run migrations for test database
    $database->migrate();

    // Disable foreign key constraints for tests
    $database->getConnection()->exec('PRAGMA foreign_keys = OFF');

    return $database;
}

function cleanTestDatabase(Database $database): void
{
    $connection = $database->getConnection();

    // Clean all tables
    $tables = ['articles', 'categories', 'tags', 'article_tags', 'users', 'sessions'];

    foreach ($tables as $table) {
        $connection->exec("DELETE FROM {$table}");
    }
}

function createTestUser(Database $database): array
{
    $connection = $database->getConnection();

    // Check if user already exists
    $checkSql = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->execute(['test@example.com']);
    $existingUser = $checkStmt->fetch();

    if ($existingUser) {
        return $existingUser;
    }

    $userData = [
        'email'    => 'test@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'name'     => 'Test User',
        'role'     => 'admin',
    ];

    $sql  = 'INSERT INTO users (email, password, name, role) VALUES (?, ?, ?, ?)';
    $stmt = $connection->prepare($sql);
    $stmt->execute(array_values($userData));

    $userData['id'] = (int) $connection->lastInsertId();

    return $userData;
}

function createTestArticle(Database $database, int $authorId = 1): array
{
    $connection = $database->getConnection();

    // Ensure user exists
    $userCheck = $connection->prepare("SELECT id FROM users WHERE id = ?");
    $userCheck->execute([$authorId]);
    if (!$userCheck->fetch()) {
        // Create user if doesn't exist
        createTestUser($database);
    }

    $articleData = [
        'title'        => 'Test Article',
        'slug'         => 'test-article-' . uniqid(), // Make slug unique
        'excerpt'      => 'This is a test article excerpt.',
        'content'      => 'This is the full content of the test article.',
        'status'       => 'published',
        'author_id'    => $authorId,
        'published_at' => date('Y-m-d H:i:s'),
        'created_at'   => date('Y-m-d H:i:s'),
        'updated_at'   => date('Y-m-d H:i:s'),
    ];

    $sql = 'INSERT INTO articles (title, slug, excerpt, content, status, author_id, published_at, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $connection->prepare($sql);
    $stmt->execute(array_values($articleData));

    $articleData['id'] = (int) $connection->lastInsertId();

    return $articleData;
}

function createTestCategory(Database $database): array
{
    $connection = $database->getConnection();

    $categoryData = [
        'name'        => 'Test Category',
        'slug'        => 'test-category',
        'description' => 'This is a test category.',
        'created_at'  => date('Y-m-d H:i:s'),
    ];

    $sql  = 'INSERT INTO categories (name, slug, description, created_at) VALUES (?, ?, ?, ?)';
    $stmt = $connection->prepare($sql);
    $stmt->execute(array_values($categoryData));

    $categoryData['id'] = (int) $connection->lastInsertId();

    return $categoryData;
}

// Mock HTTP globals for testing
function mockHttpGlobals(array $get = [], array $post = [], array $server = []): void
{
    $_GET    = $get;
    $_POST   = $post;
    $_SERVER = array_merge([
        'REQUEST_METHOD'  => 'GET',
        'REQUEST_URI'     => '/',
        'HTTP_HOST'       => 'localhost',
        'SERVER_NAME'     => 'localhost',
        'SERVER_PORT'     => '80',
        'HTTPS'           => 'off',
        'HTTP_USER_AGENT' => 'PHPUnit Test',
        'REMOTE_ADDR'     => '127.0.0.1',
    ], $server);
}

// Clean up function
function cleanupTestEnvironment(): void
{
    // Clean session
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }

    // Clean globals
    $_GET     = [];
    $_POST    = [];
    $_SESSION = [];
    $_COOKIE  = [];

    // Clean output buffer
    while (ob_get_level()) {
        ob_end_clean();
    }
}

// Register cleanup function
register_shutdown_function('cleanupTestEnvironment');
