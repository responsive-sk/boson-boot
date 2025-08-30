<?php

declare(strict_types=1);

namespace Tests\Integration\Blog\Infrastructure;

use Boson\Blog\Domain\Article;
use Boson\Blog\Domain\ArticleStatus;
use Boson\Blog\Infrastructure\SqliteArticleRepository;
use Boson\Shared\Infrastructure\Database;
use PHPUnit\Framework\TestCase;

class SqliteArticleRepositoryTest extends TestCase
{
    private Database $database;
    private SqliteArticleRepository $repository;

    protected function setUp(): void
    {
        $this->database = createTestDatabase();
        $this->repository = new SqliteArticleRepository($this->database);
        
        // Create test user
        createTestUser($this->database);
    }

    protected function tearDown(): void
    {
        cleanTestDatabase($this->database);
    }

    public function testSaveNewArticle(): void
    {
        $article = Article::create(
            title: 'Test Article',
            slug: 'test-article',
            content: 'Test content',
            authorId: 1,
            excerpt: 'Test excerpt'
        );

        $savedArticle = $this->repository->save($article);

        $this->assertNotNull($savedArticle->getId());
        $this->assertSame('Test Article', $savedArticle->getTitle());
        $this->assertSame('test-article', $savedArticle->getSlug());
        $this->assertSame('Test content', $savedArticle->getContent());
        $this->assertSame('Test excerpt', $savedArticle->getExcerpt());
        $this->assertSame(1, $savedArticle->getAuthorId());
    }

    public function testUpdateExistingArticle(): void
    {
        // Create and save initial article
        $article = Article::create(
            title: 'Original Title',
            slug: 'original-slug',
            content: 'Original content',
            authorId: 1
        );

        $savedArticle = $this->repository->save($article);
        $originalId = $savedArticle->getId();

        // Update the article
        $savedArticle->updateContent(
            title: 'Updated Title',
            content: 'Updated content'
        );

        $updatedArticle = $this->repository->save($savedArticle);

        $this->assertSame($originalId, $updatedArticle->getId());
        $this->assertSame('Updated Title', $updatedArticle->getTitle());
        $this->assertSame('Updated content', $updatedArticle->getContent());
    }

    public function testFindById(): void
    {
        $testData = createTestArticle($this->database, 1);
        
        $foundArticle = $this->repository->findById($testData['id']);

        $this->assertNotNull($foundArticle);
        $this->assertSame($testData['id'], $foundArticle->getId());
        $this->assertSame($testData['title'], $foundArticle->getTitle());
        $this->assertSame($testData['slug'], $foundArticle->getSlug());
    }

    public function testFindByIdNotFound(): void
    {
        $foundArticle = $this->repository->findById(999);

        $this->assertNull($foundArticle);
    }

    public function testFindBySlug(): void
    {
        $testData = createTestArticle($this->database, 1);
        
        $foundArticle = $this->repository->findBySlug($testData['slug']);

        $this->assertNotNull($foundArticle);
        $this->assertSame($testData['id'], $foundArticle->getId());
        $this->assertSame($testData['slug'], $foundArticle->getSlug());
    }

    public function testFindBySlugNotFound(): void
    {
        $foundArticle = $this->repository->findBySlug('non-existent-slug');

        $this->assertNull($foundArticle);
    }

    public function testFindPublished(): void
    {
        // Create published articles
        createTestArticle($this->database, 1);
        createTestArticle($this->database, 1);
        
        // Create draft article
        $connection = $this->database->getConnection();
        $sql = "INSERT INTO articles (title, slug, content, status, author_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'Draft Article',
            'draft-article',
            'Draft content',
            'draft',
            1,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        $publishedArticles = $this->repository->findPublished(10, 0);

        $this->assertCount(2, $publishedArticles);
        foreach ($publishedArticles as $article) {
            $this->assertTrue($article->isPublished());
        }
    }

    public function testFindByStatus(): void
    {
        // Create articles with different statuses
        createTestArticle($this->database, 1); // published
        
        $connection = $this->database->getConnection();
        $sql = "INSERT INTO articles (title, slug, content, status, author_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
        // Draft article
        $stmt->execute([
            'Draft Article',
            'draft-article',
            'Draft content',
            'draft',
            1,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        $draftArticles = $this->repository->findByStatus(ArticleStatus::DRAFT, 10, 0);
        $publishedArticles = $this->repository->findByStatus(ArticleStatus::PUBLISHED, 10, 0);

        $this->assertCount(1, $draftArticles);
        $this->assertCount(1, $publishedArticles);
        
        $this->assertTrue($draftArticles[0]->isDraft());
        $this->assertTrue($publishedArticles[0]->isPublished());
    }

    public function testCountByStatus(): void
    {
        // Create articles with different statuses
        createTestArticle($this->database, 1); // published
        createTestArticle($this->database, 1); // published
        
        $connection = $this->database->getConnection();
        $sql = "INSERT INTO articles (title, slug, content, status, author_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'Draft Article',
            'draft-article',
            'Draft content',
            'draft',
            1,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        $publishedCount = $this->repository->countByStatus(ArticleStatus::PUBLISHED);
        $draftCount = $this->repository->countByStatus(ArticleStatus::DRAFT);

        $this->assertSame(2, $publishedCount);
        $this->assertSame(1, $draftCount);
    }

    public function testDelete(): void
    {
        $testData = createTestArticle($this->database, 1);
        
        $result = $this->repository->delete($testData['id']);
        $this->assertTrue($result);

        $foundArticle = $this->repository->findById($testData['id']);
        $this->assertNull($foundArticle);
    }

    public function testSlugExists(): void
    {
        $testData = createTestArticle($this->database, 1);
        
        $exists = $this->repository->slugExists($testData['slug']);
        $this->assertTrue($exists);

        $notExists = $this->repository->slugExists('non-existent-slug');
        $this->assertFalse($notExists);
    }

    public function testSlugExistsWithExclusion(): void
    {
        $testData = createTestArticle($this->database, 1);
        
        // Should return false when excluding the same article
        $exists = $this->repository->slugExists($testData['slug'], $testData['id']);
        $this->assertFalse($exists);
        
        // Should return true when excluding different article
        $exists = $this->repository->slugExists($testData['slug'], 999);
        $this->assertTrue($exists);
    }

    public function testSearch(): void
    {
        // Create test articles with searchable content
        $connection = $this->database->getConnection();
        $sql = "INSERT INTO articles (title, slug, excerpt, content, status, author_id, published_at, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
        $stmt->execute([
            'PHP Tutorial',
            'php-tutorial',
            'Learn PHP programming',
            'This is a comprehensive PHP tutorial for beginners',
            'published',
            1,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        $stmt->execute([
            'JavaScript Guide',
            'javascript-guide',
            'Learn JavaScript',
            'This guide covers JavaScript fundamentals',
            'published',
            1,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        $results = $this->repository->search('PHP', 10);

        $this->assertCount(1, $results);
        $this->assertSame('PHP Tutorial', $results[0]->getTitle());
    }
}
