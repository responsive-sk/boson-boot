<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Article;

/**
 * Get Article by Slug Query
 */
final class GetArticleBySlugQuery
{
    public function __construct(
        private string $slug,
        private bool $publishedOnly = true
    ) {
        if (empty(trim($slug))) {
            throw new \InvalidArgumentException('Article slug cannot be empty');
        }
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isPublishedOnly(): bool
    {
        return $this->publishedOnly;
    }
}
