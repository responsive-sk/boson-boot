<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

interface ArticleRepository
{
    public function save(Article $article): Article;
    
    public function findById(int $id): ?Article;
    
    public function findBySlug(string $slug): ?Article;
    
    /**
     * @return Article[]
     */
    public function findPublished(int $limit = 10, int $offset = 0): array;
    
    /**
     * @return Article[]
     */
    public function findByStatus(ArticleStatus $status, int $limit = 10, int $offset = 0): array;
    
    /**
     * @return Article[]
     */
    public function findByCategory(int $categoryId, int $limit = 10, int $offset = 0): array;
    
    /**
     * @return Article[]
     */
    public function search(string $query, int $limit = 10): array;
    
    public function countByStatus(ArticleStatus $status): int;
    
    public function delete(int $id): bool;
    
    public function slugExists(string $slug, ?int $excludeId = null): bool;
}
