<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Blog\Domain\Article;
use Boson\Blog\Domain\ArticleRepository;
use Boson\Blog\Domain\ArticleStatus;

class ArticleService
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createArticle(
        string $title,
        string $content,
        int $authorId,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): Article {
        $slug = $this->generateUniqueSlug($title);
        
        $article = Article::create(
            title: $title,
            slug: $slug,
            content: $content,
            authorId: $authorId,
            excerpt: $excerpt,
            featuredImage: $featuredImage,
            categoryId: $categoryId
        );

        return $this->repository->save($article);
    }

    public function updateArticle(
        int $id,
        string $title,
        string $content,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): ?Article {
        $article = $this->repository->findById($id);
        
        if (!$article) {
            return null;
        }

        $article->updateContent(
            title: $title,
            content: $content,
            excerpt: $excerpt,
            featuredImage: $featuredImage,
            categoryId: $categoryId
        );

        return $this->repository->save($article);
    }

    public function publishArticle(int $id): ?Article
    {
        $article = $this->repository->findById($id);
        
        if (!$article) {
            return null;
        }

        $article->publish();
        
        return $this->repository->save($article);
    }

    public function unpublishArticle(int $id): ?Article
    {
        $article = $this->repository->findById($id);
        
        if (!$article) {
            return null;
        }

        $article->unpublish();
        
        return $this->repository->save($article);
    }

    public function archiveArticle(int $id): ?Article
    {
        $article = $this->repository->findById($id);
        
        if (!$article) {
            return null;
        }

        $article->archive();
        
        return $this->repository->save($article);
    }

    public function deleteArticle(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getArticleById(int $id): ?Article
    {
        return $this->repository->findById($id);
    }

    public function getArticleBySlug(string $slug): ?Article
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * @return Article[]
     */
    public function getPublishedArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->repository->findPublished($limit, $offset);
    }

    /**
     * @return Article[]
     */
    public function getArticlesByStatus(ArticleStatus $status, int $limit = 10, int $offset = 0): array
    {
        return $this->repository->findByStatus($status, $limit, $offset);
    }

    /**
     * @return Article[]
     */
    public function getArticlesByCategory(int $categoryId, int $limit = 10, int $offset = 0, bool $publishedOnly = true): array
    {
        return $this->repository->findByCategory($categoryId, $limit, $offset, $publishedOnly);
    }

    /**
     * @return Article[]
     */
    public function searchArticles(string $query, int $limit = 10): array
    {
        return $this->repository->search($query, $limit);
    }

    public function getArticleCount(ArticleStatus $status): int
    {
        return $this->repository->countByStatus($status);
    }

    public function getPublishedArticleCount(): int
    {
        return $this->repository->countByStatus(ArticleStatus::PUBLISHED);
    }

    /**
     * @return array{articles: Article[], total: int, hasMore: bool}
     */
    public function getPaginatedArticles(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $articles = $this->repository->findPublished($perPage + 1, $offset);
        
        $hasMore = count($articles) > $perPage;
        if ($hasMore) {
            array_pop($articles); // Remove the extra article
        }

        $total = $this->getPublishedArticleCount();

        return [
            'articles' => $articles,
            'total' => $total,
            'hasMore' => $hasMore,
            'currentPage' => $page,
            'perPage' => $perPage,
            'totalPages' => (int) ceil($total / $perPage)
        ];
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = $this->generateSlugFromTitle($title);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->repository->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function generateSlugFromTitle(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
