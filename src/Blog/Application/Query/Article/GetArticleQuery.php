<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Article;

use Boson\Blog\Domain\ValueObject\ArticleId;

/**
 * Get Single Article Query
 */
final class GetArticleQuery
{
    public function __construct(
        private ArticleId $id,
        private bool $publishedOnly = true
    ) {}

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function isPublishedOnly(): bool
    {
        return $this->publishedOnly;
    }

    public static function fromInt(int $id, bool $publishedOnly = true): self
    {
        return new self(ArticleId::fromInt($id), $publishedOnly);
    }

    public static function fromString(string $id, bool $publishedOnly = true): self
    {
        return new self(ArticleId::fromString($id), $publishedOnly);
    }
}
