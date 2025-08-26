<?php

declare(strict_types=1);

namespace Boson\Blog\Infrastructure;

use Boson\Blog\Domain\Article;
use Boson\Blog\Domain\ArticleRepository;
use Boson\Blog\Domain\ArticleStatus;
use Boson\Shared\Infrastructure\Database;
use PDO;

class SqliteArticleRepository implements ArticleRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(Article $article): Article
    {
        $connection = $this->database->getConnection();

        if ($article->getId() === null) {
            // Insert new article
            $sql = "INSERT INTO articles (title, slug, excerpt, content, featured_image, status, category_id, author_id, published_at, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $connection->prepare($sql);
            $stmt->execute([
                $article->getTitle(),
                $article->getSlug(),
                $article->getExcerpt(),
                $article->getContent(),
                $article->getFeaturedImage(),
                $article->getStatus()->value,
                $article->getCategoryId(),
                $article->getAuthorId(),
                $article->getPublishedAt()?->format('Y-m-d H:i:s'),
                $article->getCreatedAt()->format('Y-m-d H:i:s'),
                $article->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            $article->setId((int) $connection->lastInsertId());
        } else {
            // Update existing article
            $sql = "UPDATE articles SET title = ?, slug = ?, excerpt = ?, content = ?, featured_image = ?, 
                    status = ?, category_id = ?, published_at = ?, updated_at = ? WHERE id = ?";
            
            $stmt = $connection->prepare($sql);
            $stmt->execute([
                $article->getTitle(),
                $article->getSlug(),
                $article->getExcerpt(),
                $article->getContent(),
                $article->getFeaturedImage(),
                $article->getStatus()->value,
                $article->getCategoryId(),
                $article->getPublishedAt()?->format('Y-m-d H:i:s'),
                $article->getUpdatedAt()->format('Y-m-d H:i:s'),
                $article->getId()
            ]);
        }

        return $article;
    }

    public function findById(int $id): ?Article
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? Article::fromArray($data) : null;
    }

    public function findBySlug(string $slug): ?Article
    {
        $sql = "SELECT * FROM articles WHERE slug = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$slug]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? Article::fromArray($data) : null;
    }

    public function findPublished(int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM articles WHERE status = 'published' 
                ORDER BY published_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$limit, $offset]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($data) => Article::fromArray($data), $results);
    }

    public function findByStatus(ArticleStatus $status, int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM articles WHERE status = ? 
                ORDER BY created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$status->value, $limit, $offset]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($data) => Article::fromArray($data), $results);
    }

    public function findByCategory(int $categoryId, int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM articles WHERE category_id = ? AND status = 'published' 
                ORDER BY published_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$categoryId, $limit, $offset]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($data) => Article::fromArray($data), $results);
    }

    public function search(string $query, int $limit = 10): array
    {
        $sql = "SELECT a.* FROM articles a
                JOIN articles_fts fts ON a.id = fts.rowid
                WHERE articles_fts MATCH ? AND a.status = 'published'
                ORDER BY rank LIMIT ?";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$query, $limit]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($data) => Article::fromArray($data), $results);
    }

    public function countByStatus(ArticleStatus $status): int
    {
        $sql = "SELECT COUNT(*) FROM articles WHERE status = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$status->value]);
        
        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM articles WHERE id = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        
        return $stmt->execute([$id]);
    }

    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM articles WHERE slug = ? AND id != ?";
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$slug, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM articles WHERE slug = ?";
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$slug]);
        }
        
        return (int) $stmt->fetchColumn() > 0;
    }
}
