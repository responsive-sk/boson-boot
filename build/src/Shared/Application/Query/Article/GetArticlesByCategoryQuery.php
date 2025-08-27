<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Query\Article;

/**
 * Get Articles by Category Query
 */
final class GetArticlesByCategoryQuery
{
    private const DEFAULT_LIMIT = 10;
    private const MAX_LIMIT = 100;

    public function __construct(
        private int $categoryId,
        private int $limit = self::DEFAULT_LIMIT,
        private int $offset = 0,
        private bool $publishedOnly = true,
        private string $sortBy = 'created_at',
        private string $sortDirection = 'DESC'
    ) {
        $this->validateCategoryId($categoryId);
        $this->validateLimit($limit);
        $this->validateSort($sortBy, $sortDirection);
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function isPublishedOnly(): bool
    {
        return $this->publishedOnly;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    /**
     * Get page number (1-based)
     */
    public function getPage(): int
    {
        return (int) floor($this->offset / $this->limit) + 1;
    }

    private function validateCategoryId(int $categoryId): void
    {
        if ($categoryId <= 0) {
            throw new \InvalidArgumentException('Category ID must be positive integer');
        }
    }

    private function validateLimit(int $limit): void
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Limit must be positive integer');
        }

        if ($limit > self::MAX_LIMIT) {
            throw new \InvalidArgumentException(
                sprintf('Limit cannot exceed %d', self::MAX_LIMIT)
            );
        }
    }

    private function validateSort(string $sortBy, string $sortDirection): void
    {
        $validSortFields = ['id', 'title', 'created_at', 'updated_at', 'published_at'];
        $validDirections = ['ASC', 'DESC'];

        if (!in_array($sortBy, $validSortFields, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid sort field: %s', $sortBy)
            );
        }

        if (!in_array(strtoupper($sortDirection), $validDirections, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid sort direction: %s', $sortDirection)
            );
        }
    }
}
