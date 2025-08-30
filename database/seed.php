<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/seeders/ArticleSeeder.php';

use Boson\Shared\Infrastructure\ServiceFactory;
use Database\Seeders\ArticleSeeder;

// Load environment variables manually
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && !str_starts_with($line, '#')) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

echo "🌱 Starting database seeding...\n\n";

try {
    // Create service factory
    $factory = new ServiceFactory();
    $database = $factory->createDatabase();

    // Run migrations first
    echo "📋 Running migrations...\n";
    $database->migrate();

    // Run article seeder
    echo "🌱 Seeding articles...\n";
    $articleSeeder = new ArticleSeeder($database);
    $articleSeeder->run();
    
    echo "\n🎉 Database seeding completed successfully!\n";
    
} catch (Exception $e) {
    echo "\n❌ Seeding failed: " . $e->getMessage() . "\n";
    exit(1);
}
