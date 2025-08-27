<?php

declare(strict_types=1);

namespace Boson\Shared\Presentation\Response;

/**
 * Articles Collection Response Object
 */
final class ArticlesResponse
{
    public function __construct(
        private array $articles,
        private int $total,
        private int $currentPage,
        private int $perPage,
        private int $totalPages,
        private bool $hasMore
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
        return $this->totalPages;
    }

    public function hasMore(): bool
    {
        return $this->hasMore;
    }

    public function hasPrevious(): bool
    {
        return $this->currentPage > 1;
    }

    public function getNextPage(): ?int
    {
        return $this->hasMore ? $this->currentPage + 1 : null;
    }

    public function getPreviousPage(): ?int
    {
        return $this->hasPrevious() ? $this->currentPage - 1 : null;
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
        $totalPages = (int) ceil($total / $perPage);
        $hasMore = $currentPage < $totalPages;

        return new self(
            articles: $articles,
            total: $total,
            currentPage: $currentPage,
            perPage: $perPage,
            totalPages: $totalPages,
            hasMore: $hasMore
        );
    }

    /**
     * Convert to array for JSON serialization
     */
    public function toArray(): array
    {
        return [
            'articles' => array_map(
                fn($article) => $article instanceof ArticleResponse 
                    ? $article->toArray() 
                    : $article,
                $this->articles
            ),
            'pagination' => [
                'total' => $this->total,
                'current_page' => $this->currentPage,
                'per_page' => $this->perPage,
                'total_pages' => $this->totalPages,
                'has_more' => $this->hasMore,
                'has_previous' => $this->hasPrevious(),
                'next_page' => $this->getNextPage(),
                'previous_page' => $this->getPreviousPage(),
            ]
        ];
    }
}
