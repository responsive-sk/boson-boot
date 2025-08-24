<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

interface BlogPostRepository
{
    public function save(BlogPost $blogPost): BlogPost;
    
    public function findById(int $id): ?BlogPost;
    
    public function findBySlug(string $slug): ?BlogPost;
    
    public function findPublished(int $limit = 10, int $offset = 0): array;
    
    public function findByStatus(BlogPostStatus $status, int $limit = 10, int $offset = 0): array;
    
    public function findByCategory(int $categoryId, int $limit = 10, int $offset = 0): array;
    
    public function search(string $query, int $limit = 10): array;
    
    public function countByStatus(BlogPostStatus $status): int;
    
    public function delete(int $id): bool;
    
    public function slugExists(string $slug, ?int $excludeId = null): bool;
}
