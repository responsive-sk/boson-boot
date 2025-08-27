<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Command\Search;

/**
 * Search Articles Command
 */
final class SearchArticlesCommand
{
    private const MIN_QUERY_LENGTH = 2;
    private const MAX_QUERY_LENGTH = 255;
    private const DEFAULT_LIMIT = 20;
    private const MAX_LIMIT = 100;

    public function __construct(
        private string $query,
        private int $limit = self::DEFAULT_LIMIT,
        private int $offset = 0,
        private ?int $categoryId = null,
        private array $tags = [],
        private bool $publishedOnly = true
    ) {
        $this->validateQuery($query);
        $this->validateLimit($limit);
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
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

    /**
     * Get page number (1-based)
     */
    public function getPage(): int
    {
        return (int) floor($this->offset / $this->limit) + 1;
    }

    private function validateQuery(string $query): void
    {
        $trimmed = trim($query);
        
        if (strlen($trimmed) < self::MIN_QUERY_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Search query must be at least %d characters long', self::MIN_QUERY_LENGTH)
            );
        }

        if (strlen($trimmed) > self::MAX_QUERY_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Search query cannot exceed %d characters', self::MAX_QUERY_LENGTH)
            );
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

    /**
     * Create from array data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            query: $data['query'] ?? '',
            limit: (int) ($data['limit'] ?? self::DEFAULT_LIMIT),
            offset: (int) ($data['offset'] ?? 0),
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            tags: $data['tags'] ?? [],
            publishedOnly: (bool) ($data['published_only'] ?? true)
        );
    }
}
