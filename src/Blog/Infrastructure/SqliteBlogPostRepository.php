<?php

declare(strict_types=1);

namespace Boson\Blog\Infrastructure;

use Boson\Blog\Domain\BlogPost;
use Boson\Blog\Domain\BlogPostRepository;
use Boson\Blog\Domain\BlogPostStatus;
use Boson\Shared\Infrastructure\Database;
use PDO;

class SqliteBlogPostRepository implements BlogPostRepository
{
    public function __construct(
        private Database $database
    ) {}

    public function save(BlogPost $blogPost): BlogPost
    {
        $data = $blogPost->toArray();
        
        if ($data['id'] === null) {
            return $this->insert($blogPost);
        } else {
            return $this->update($blogPost);
        }
    }

    private function insert(BlogPost $blogPost): BlogPost
    {
        $data = $blogPost->toArray();
        unset($data['id']); // Remove null ID for insert
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO blog_posts ({$columns}) VALUES ({$placeholders})";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($data);
        
        $id = (int) $this->database->getConnection()->lastInsertId();
        
        return $this->findById($id);
    }

    private function update(BlogPost $blogPost): BlogPost
    {
        $data = $blogPost->toArray();
        $id = $data['id'];
        unset($data['id']);
        
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE blog_posts SET {$setClause} WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($data);
        
        return $this->findById($id);
    }

    public function findById(int $id): ?BlogPost
    {
        $sql = "SELECT * FROM blog_posts WHERE id = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? BlogPost::fromArray($data) : null;
    }

    public function findBySlug(string $slug): ?BlogPost
    {
        $sql = "SELECT * FROM blog_posts WHERE slug = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$slug]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? BlogPost::fromArray($data) : null;
    }

    public function findPublished(int $limit = 10, int $offset = 0): array
    {
        return $this->findByStatus(BlogPostStatus::PUBLISHED, $limit, $offset);
    }

    public function findByStatus(BlogPostStatus $status, int $limit = 10, int $offset = 0): array
    {
        $sql = "
            SELECT bp.*, c.name as category_name, u.name as author_name
            FROM blog_posts bp
            LEFT JOIN categories c ON bp.category_id = c.id
            LEFT JOIN users u ON bp.author_id = u.id
            WHERE bp.status = ?
            ORDER BY bp.published_at DESC, bp.created_at DESC
            LIMIT ? OFFSET ?
        ";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$status->value, $limit, $offset]);
        
        $posts = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = BlogPost::fromArray($data);
        }
        
        return $posts;
    }

    public function findByCategory(int $categoryId, int $limit = 10, int $offset = 0): array
    {
        $sql = "
            SELECT bp.*, c.name as category_name, u.name as author_name
            FROM blog_posts bp
            LEFT JOIN categories c ON bp.category_id = c.id
            LEFT JOIN users u ON bp.author_id = u.id
            WHERE bp.category_id = ? AND bp.status = 'published'
            ORDER BY bp.published_at DESC
            LIMIT ? OFFSET ?
        ";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$categoryId, $limit, $offset]);
        
        $posts = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = BlogPost::fromArray($data);
        }
        
        return $posts;
    }

    public function search(string $query, int $limit = 10): array
    {
        // Try FTS first
        try {
            $sql = "
                SELECT bp.*, c.name as category_name, u.name as author_name
                FROM blog_posts_fts
                JOIN blog_posts bp ON blog_posts_fts.rowid = bp.id
                LEFT JOIN categories c ON bp.category_id = c.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE blog_posts_fts MATCH ? AND bp.status = 'published'
                ORDER BY bm_rank(blog_posts_fts)
                LIMIT ?
            ";
            
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$query, $limit]);
        } catch (\Exception $e) {
            // Fallback to LIKE search
            $sql = "
                SELECT bp.*, c.name as category_name, u.name as author_name
                FROM blog_posts bp
                LEFT JOIN categories c ON bp.category_id = c.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE (bp.title LIKE ? OR bp.excerpt LIKE ? OR bp.content LIKE ?)
                AND bp.status = 'published'
                ORDER BY bp.published_at DESC
                LIMIT ?
            ";
            
            $searchTerm = '%' . $query . '%';
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit]);
        }
        
        $posts = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = BlogPost::fromArray($data);
        }
        
        return $posts;
    }

    public function countByStatus(BlogPostStatus $status): int
    {
        $sql = "SELECT COUNT(*) FROM blog_posts WHERE status = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$status->value]);
        
        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM blog_posts WHERE id = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        
        return $stmt->execute([$id]);
    }

    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM blog_posts WHERE slug = ? AND id != ?";
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$slug, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM blog_posts WHERE slug = ?";
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$slug]);
        }
        
        return $stmt->fetchColumn() > 0;
    }
}
