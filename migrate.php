<?php
/**
 * Database Migration Script
 * Run this to create and seed the database
 */

require_once __DIR__ . '/vendor/autoload.php';

use Boson\Shared\Infrastructure\Config;
use Boson\Shared\Infrastructure\Database;

try {
    echo "🚀 Starting database migration...\n\n";

    // Load configuration
    $config = Config::getInstance();
    echo "✅ Configuration loaded\n";

    // Create database connection
    $database = new Database($config);
    echo "✅ Database connection established\n";

    // Run migrations
    echo "📊 Creating tables...\n";
    $database->migrate();
    echo "✅ Tables created successfully\n";

    // Seed data
    echo "🌱 Seeding initial data...\n";
    $database->seed();
    echo "✅ Data seeded successfully\n";

    echo "\n🎉 Migration completed successfully!\n";
    echo "📍 Database location: " . $config->getDbPath() . "\n";
    echo "👤 Admin email: " . $config->get('ADMIN_EMAIL') . "\n";
    echo "🔑 Admin password: " . $config->get('ADMIN_PASSWORD') . "\n";
    echo "\n💡 You can now start the server with: php -S localhost:8080 -t public\n";

} catch (Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
