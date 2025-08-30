<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Article;

/**
 * Get Articles by Category Query
 */
final class GetArticlesByCategoryQuery
{
    public function __construct(
        private int $categoryId,
        private int $limit = 10,
        private int $offset = 0
    ) {}

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
}
