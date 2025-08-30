<?php

declare(strict_types=1);

namespace Boson\Blog\Presentation\Response;

/**
 * Articles Collection Response Object
 */
final class ArticlesResponse
{
    public function __construct(
        private array $articles,
        private int $total,
        private int $currentPage,
        private int $perPage
    ) {}

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->total / $this->perPage);
    }

    public function hasMore(): bool
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function hasPrevious(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * Create from array of articles and pagination data
     */
    public static function create(
        array $articles,
        int $total,
        int $currentPage,
        int $perPage
    ): self {
        return new self(
            articles: $articles,
            total: $total,
            currentPage: $currentPage,
            perPage: $perPage
        );
    }

    public function toArray(): array
    {
        return [
            'articles' => array_map(
                fn($article) => $article instanceof ArticleResponse
                    ? $article->toArray()
                    : $article,
                $this->articles
            ),
            'total' => $this->total,
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total_pages' => $this->getTotalPages(),
            'has_more' => $this->hasMore(),
            'has_previous' => $this->hasPrevious()
        ];
    }
}
