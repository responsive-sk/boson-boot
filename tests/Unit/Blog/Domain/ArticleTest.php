<?php

declare(strict_types=1);

namespace Tests\Unit\Blog\Domain;

use Boson\Blog\Domain\Article;
use Boson\Blog\Domain\ArticleStatus;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testCreateArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1,
            excerpt: 'Test excerpt'
        );

        $this->assertNull($article->getId());
        $this->assertSame('Test Article', $article->getTitle());
        $this->assertSame('test-article', $article->getSlug());
        $this->assertSame('Test content', $article->getContent());
        $this->assertSame('Test excerpt', $article->getExcerpt());
        $this->assertSame(1, $article->getAuthorId());
        $this->assertSame(ArticleStatus::DRAFT, $article->getStatus());
        $this->assertNull($article->getPublishedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getCreatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getUpdatedAt());
    }

    public function testPublishArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $this->assertFalse($article->isPublished());
        $this->assertTrue($article->isDraft());

        $article->publish();

        $this->assertTrue($article->isPublished());
        $this->assertFalse($article->isDraft());
        $this->assertSame(ArticleStatus::PUBLISHED, $article->getStatus());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getPublishedAt());
    }

    public function testCannotPublishAlreadyPublishedArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $article->publish();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Article is already published');

        $article->publish();
    }

    public function testUnpublishArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $article->publish();
        $this->assertTrue($article->isPublished());

        $article->unpublish();

        $this->assertFalse($article->isPublished());
        $this->assertTrue($article->isDraft());
        $this->assertSame(ArticleStatus::DRAFT, $article->getStatus());
    }

    public function testCannotUnpublishNonPublishedArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Article is not published');

        $article->unpublish();
    }

    public function testArchiveArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $article->archive();

        $this->assertTrue($article->isArchived());
        $this->assertFalse($article->isDraft());
        $this->assertFalse($article->isPublished());
        $this->assertSame(ArticleStatus::ARCHIVED, $article->getStatus());
    }

    public function testUpdateContent(): void
    {
        $article = Article::create(
            title: 'Original Title',
            slug: 'original-slug',
            content: 'Original content',
            authorId: 1
        );

        $originalUpdatedAt = $article->getUpdatedAt();

        // Sleep to ensure timestamp difference
        usleep(1000);

        $article->updateContent(
            title: 'Updated Title',
            content: 'Updated content',
            excerpt: 'Updated excerpt'
        );

        $this->assertSame('Updated Title', $article->getTitle());
        $this->assertSame('Updated content', $article->getContent());
        $this->assertSame('Updated excerpt', $article->getExcerpt());
        $this->assertGreaterThan($originalUpdatedAt, $article->getUpdatedAt());
    }

    public function testToArray(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1,
            excerpt: 'Test excerpt'
        );

        $array = $article->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('slug', $array);
        $this->assertArrayHasKey('content', $array);
        $this->assertArrayHasKey('excerpt', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('author_id', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);

        $this->assertSame('Test Article', $array['title']);
        $this->assertSame('test-article', $array['slug']);
        $this->assertSame('draft', $array['status']);
        $this->assertSame(1, $array['author_id']);
    }

    public function testFromArray(): void
    {
        $data = [
            'id' => 1,
            'title' => 'Test Article',
            'slug' => 'test-article',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'featured_image' => null,
            'status' => 'published',
            'category_id' => null,
            'author_id' => 1,
            'published_at' => '2024-01-01 12:00:00',
            'created_at' => '2024-01-01 10:00:00',
            'updated_at' => '2024-01-01 11:00:00'
        ];

        $article = Article::fromArray($data);

        $this->assertSame(1, $article->getId());
        $this->assertSame('Test Article', $article->getTitle());
        $this->assertSame('test-article', $article->getSlug());
        $this->assertSame('Test excerpt', $article->getExcerpt());
        $this->assertSame('Test content', $article->getContent());
        $this->assertSame(ArticleStatus::PUBLISHED, $article->getStatus());
        $this->assertSame(1, $article->getAuthorId());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getPublishedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getCreatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getUpdatedAt());
    }

    public function testGenerateSlug(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1
        );

        $slug = $article->generateSlug('Hello World! This is a Test.');
        $this->assertSame('hello-world-this-is-a-test', $slug);

        $slug = $article->generateSlug('Special Characters: @#$%^&*()');
        $this->assertSame('special-characters', $slug);

        $slug = $article->generateSlug('Multiple   Spaces   And---Dashes');
        $this->assertSame('multiple-spaces-and-dashes', $slug);
    }
}
