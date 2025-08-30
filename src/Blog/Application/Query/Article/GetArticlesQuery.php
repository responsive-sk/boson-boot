<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Article;

/**
 * Get Articles Query with Pagination
 */
final class GetArticlesQuery
{
    public function __construct(
        private int $page = 1,
        private int $perPage = 10,
        private string $sortBy = 'published_at',
        private string $sortDirection = 'DESC'
    ) {}

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }
}
