<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Command\Search;

/**
 * Search Articles Command
 */
final class SearchArticlesCommand
{
    public function __construct(
        private string $query,
        private int $limit = 10
    ) {}

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
