<?php

/**
 * Boson PHP - Article Value Objects Usage Examples
 *
 * This file demonstrates how to use the Article Value Objects
 * in your application code.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Blog\Domain\ValueObject\ArticleTitle;
use Boson\Blog\Domain\ValueObject\ArticleContent;
use Boson\Blog\Domain\ValueObject\ArticleId;
use Boson\Blog\Domain\ValueObject\ArticleStatus;

/**
 * Example 1: Creating an Article with Validated Value Objects
 */
function createArticleExample(): void
{
    try {
        // Create validated value objects
        $id = ArticleId::fromInt(1);
        $title = ArticleTitle::fromString('Getting Started with Boson PHP');
        $content = ArticleContent::fromString('This is a comprehensive guide to getting started with Boson PHP...');
        $status = ArticleStatus::fromString('draft');

        // Use in your domain logic
        $article = new Article($id, $title, $content, $status);

        echo "Article created successfully!\n";
        echo "ID: {$id}\n";
        echo "Title: {$title}\n";
        echo "Status: {$status}\n";
        echo "Content length: " . strlen($content->value()) . " characters\n";

    } catch (InvalidArgumentException $e) {
        echo "Validation error: " . $e->getMessage() . "\n";
    }
}

/**
 * Example 2: Value Object Comparison
 */
function comparisonExample(): void
{
    $title1 = ArticleTitle::fromString('My Article');
    $title2 = ArticleTitle::fromString('My Article');
    $title3 = ArticleTitle::fromString('Different Title');

    echo "title1 equals title2: " . ($title1->equals($title2) ? 'true' : 'false') . "\n";
    echo "title1 equals title3: " . ($title1->equals($title3) ? 'true' : 'false') . "\n";
    echo "title1 equals null: " . ($title1->equals(null) ? 'true' : 'false') . "\n";
}

/**
 * Example 3: Status-Specific Logic
 */
function statusLogicExample(): void
{
    $statuses = [
        ArticleStatus::fromString('draft'),
        ArticleStatus::fromString('published'),
        ArticleStatus::fromString('archived')
    ];

    foreach ($statuses as $status) {
        echo "Status: {$status}\n";
        echo "  Is Draft: " . ($status->isDraft() ? 'Yes' : 'No') . "\n";
        echo "  Is Published: " . ($status->isPublished() ? 'Yes' : 'No') . "\n";
        echo "  Is Archived: " . ($status->isArchived() ? 'Yes' : 'No') . "\n";
        echo "\n";
    }
}

/**
 * Example 4: Error Handling
 */
function errorHandlingExample(): void
{
    $invalidInputs = [
        'title' => ['', 'AB', str_repeat('A', 256)], // empty, too short, too long
        'content' => [str_repeat('A', 5)], // too short
        'id' => [0, -1], // zero or negative
        'status' => ['invalid', ''] // invalid status, empty
    ];

    echo "Testing invalid inputs:\n\n";

    // Test invalid titles
    foreach ($invalidInputs['title'] as $invalidTitle) {
        try {
            ArticleTitle::fromString($invalidTitle);
            echo "ERROR: Should have failed for title: '{$invalidTitle}'\n";
        } catch (InvalidArgumentException $e) {
            echo "✓ Title validation caught: " . $e->getMessage() . "\n";
        }
    }

    // Test invalid content
    foreach ($invalidInputs['content'] as $invalidContent) {
        try {
            ArticleContent::fromString($invalidContent);
            echo "ERROR: Should have failed for content\n";
        } catch (InvalidArgumentException $e) {
            echo "✓ Content validation caught: " . $e->getMessage() . "\n";
        }
    }

    // Test invalid IDs
    foreach ($invalidInputs['id'] as $invalidId) {
        try {
            ArticleId::fromInt($invalidId);
            echo "ERROR: Should have failed for ID: {$invalidId}\n";
        } catch (InvalidArgumentException $e) {
            echo "✓ ID validation caught: " . $e->getMessage() . "\n";
        }
    }

    // Test invalid statuses
    foreach ($invalidInputs['status'] as $invalidStatus) {
        try {
            ArticleStatus::fromString($invalidStatus);
            echo "ERROR: Should have failed for status: '{$invalidStatus}'\n";
        } catch (InvalidArgumentException $e) {
            echo "✓ Status validation caught: " . $e->getMessage() . "\n";
        }
    }
}

/**
 * Example 5: Using Value Objects in Collections/Arrays
 */
function collectionExample(): void
{
    $articles = [
        [
            'id' => ArticleId::fromInt(1),
            'title' => ArticleTitle::fromString('First Article'),
            'status' => ArticleStatus::fromString('published')
        ],
        [
            'id' => ArticleId::fromInt(2),
            'title' => ArticleTitle::fromString('Second Article'),
            'status' => ArticleStatus::fromString('draft')
        ]
    ];

    echo "Published articles:\n";
    foreach ($articles as $article) {
        if ($article['status']->isPublished()) {
            echo "- {$article['title']} (ID: {$article['id']})\n";
        }
    }
}

/**
 * Example 6: String Conversion and Display
 */
function stringConversionExample(): void
{
    $title = ArticleTitle::fromString('Sample Article Title');
    $content = ArticleContent::fromString('This is sample content for the article.');
    $id = ArticleId::fromInt(42);
    $status = ArticleStatus::fromString('published');

    echo "String representations:\n";
    echo "Title: {$title}\n";
    echo "Content: " . substr($content, 0, 50) . "...\n";
    echo "ID: {$id}\n";
    echo "Status: {$status}\n";

    echo "\nRaw values:\n";
    echo "Title value: {$title->value()}\n";
    echo "Content value: " . substr($content->value(), 0, 50) . "...\n";
    echo "ID value: {$id->value()}\n";
    echo "Status value: {$status->value()}\n";
}

// Run examples
echo "=== Boson PHP Value Objects Usage Examples ===\n\n";

echo "1. Creating an Article:\n";
createArticleExample();
echo "\n";

echo "2. Value Object Comparison:\n";
comparisonExample();
echo "\n";

echo "3. Status-Specific Logic:\n";
statusLogicExample();
echo "\n";

echo "4. Error Handling:\n";
errorHandlingExample();
echo "\n";

echo "5. Using in Collections:\n";
collectionExample();
echo "\n";

echo "6. String Conversion:\n";
stringConversionExample();
echo "\n";

echo "=== Examples Complete ===\n";
