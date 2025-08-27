<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Query\Article;

/**
 * Get Articles Query with Pagination
 */
final class GetArticlesQuery
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PER_PAGE = 10;
    private const MAX_PER_PAGE = 100;

    public function __construct(
        private int $page = self::DEFAULT_PAGE,
        private int $perPage = self::DEFAULT_PER_PAGE,
        private ?int $categoryId = null,
        private array $tags = [],
        private bool $publishedOnly = true,
        private string $sortBy = 'created_at',
        private string $sortDirection = 'DESC'
    ) {
        $this->validatePage($page);
        $this->validatePerPage($perPage);
        $this->validateSort($sortBy, $sortDirection);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getTags(): array
    {
        return $this->tags;
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

    private function validatePage(int $page): void
    {
        if ($page < 1) {
            throw new \InvalidArgumentException('Page must be positive integer');
        }
    }

    private function validatePerPage(int $perPage): void
    {
        if ($perPage < 1) {
            throw new \InvalidArgumentException('Per page must be positive integer');
        }

        if ($perPage > self::MAX_PER_PAGE) {
            throw new \InvalidArgumentException(
                sprintf('Per page cannot exceed %d', self::MAX_PER_PAGE)
            );
        }
    }

    private function validateSort(string $sortBy, string $sortDirection): void
    {
        $validSortFields = ['id', 'title', 'created_at', 'updated_at', 'published_at'];
        $validDirections = ['ASC', 'DESC'];

        if (!in_array($sortBy, $validSortFields, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid sort field: %s. Valid fields: %s', 
                    $sortBy, 
                    implode(', ', $validSortFields)
                )
            );
        }

        if (!in_array(strtoupper($sortDirection), $validDirections, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid sort direction: %s. Valid directions: %s', 
                    $sortDirection, 
                    implode(', ', $validDirections)
                )
            );
        }
    }

    /**
     * Create from array data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            page: (int) ($data['page'] ?? self::DEFAULT_PAGE),
            perPage: (int) ($data['per_page'] ?? self::DEFAULT_PER_PAGE),
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            tags: $data['tags'] ?? [],
            publishedOnly: (bool) ($data['published_only'] ?? true),
            sortBy: $data['sort_by'] ?? 'created_at',
            sortDirection: strtoupper($data['sort_direction'] ?? 'DESC')
        );
    }
}
